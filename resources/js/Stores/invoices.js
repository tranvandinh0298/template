import {defineStore} from 'pinia';
import {mande} from 'mande';
import Swal from "sweetalert2";
import {Inertia} from '@inertiajs/inertia';
import CONSTANTS from './constants';

const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const processMegapayData = mande("/transaction/process", {
    headers: {
        'X-CSRF-TOKEN': csrfToken,
        'Content-Type': 'application/json'
    }
});
export const useInvoicesStore = defineStore('invoices', {
    state: () => ({
        amount: 0,
        paymentFee: 0,
        totalAmount: 0,
        bills: [] ,
        selectedBills: [],
        paymentMethods: [],
        currentPaymentMethod: null,
        // megapayFormData: {
        //     description: '',
        //     amount: '',
        //     merchantToken: '',
        //     timeStamp: '',
        //     merId: '',
        //     invoiceNo: '',
        //     merTrxId: '',
        //     goodsNm: '',
        //     buyerAddr: '',
        //     buyerLastNm: '',
        //     buyerFirstNm: '',
        //     buyerEmail: '',
        //     buyerPhone: '',
        //     receiverAddr: '',
        //     receiverLastNm: '',
        //     receiverFirstNm: '',
        //     receiverEmail: '',
        //     receiverPhone: '',
        //     termIs: '',
        //     domain: '',
        //     payToken: '',
        //     windowColor: '#03A5E3',
        //     bankCode: "",
        //     payType: "",
        // }
    }),
    persist: {
        key: 'customer-session',
        storage: sessionStorage,
        paths: ['selectedBills', 'currentPaymentMethod']
    },
    getters: {
        unpaidBills() {
            return this.bills.filter((bill) => !bill.status);
        },
        onDisplayPaymentMethods() {
            return this.paymentMethods.filter((paymentMethod) => paymentMethod.onDisplay);
        },
        availablePaymentMethods() {
            return this.paymentMethods.filter((paymentMethod) => !paymentMethod.isRequired && !paymentMethod.onDisplay)
        },
        availablePaymentMethodImgs() {
            let imagesArr = this.availablePaymentMethods.map((paymentMethod) => paymentMethod.images);
            imagesArr = [...imagesArr];
            imagesArr = [].concat(...imagesArr);
            return Array.from(new Set(imagesArr));
        },
        availableEWPaymentMethods() {
            return this.availablePaymentMethods.filter((paymentMethod) => paymentMethod.mgpCode === 'EW')
        },
        availableICPaymentMethods() {
            return this.availablePaymentMethods.filter((paymentMethod) => paymentMethod.mgpCode === 'IC')
        },
        availableQRPaymentMethods() {
            return this.availablePaymentMethods.filter((paymentMethod) => paymentMethod.mgpCode === 'QR')
        },
        availablePLPaymentMethods() {
            return this.availablePaymentMethods.filter((paymentMethod) => paymentMethod.mgpCode === 'PL')
        }
    },
    actions: {
        initialData(bills, paymentMethods) {
            this.bills = bills;
            this.paymentMethods = paymentMethods.sort(function compare(a, b) {
                if (a.priority < b.priority) {
                    return -1;
                }
                if (a.priority > b.priority) {
                    return 1;
                }
                return 0;
            });
        },
        sortBills(list) {
            list.sort(function compare(a, b) {
                if (a.id < b.id) {
                    return -1;
                }
                if (a.id > b.id) {
                    return 1;
                }
                return 0;
            });
        },
        selectPaymentMethod(paymentMethodId) {
            if (paymentMethodId !== undefined && paymentMethodId !== null) {
                this.currentPaymentMethod = this.paymentMethods.find((paymentMethod) => paymentMethod.id === paymentMethodId);
                this.currentPaymentMethod.onDisplay = true;

                this.calculateTransaction();
            }
        },
        isCurrentPaymentMethod(id) {
            return this.currentPaymentMethod && this.currentPaymentMethod.id === id;
        },
        isBillSelected(billId) {
            return this.selectedBills.find((bill) => bill.id === billId) !== undefined;
        },
        toggleAllBills(isChecked) {
            isChecked ? this.selectAllUnpaidBills() : this.removeAllUnpaidBills();

            this.calculateTransaction();
        },
        selectAllUnpaidBills() {
            this.selectedBills = this.unpaidBills;
        },
        removeAllUnpaidBills() {
            this.selectedBills = [];
        },
        isAllUnpaidBillsSelected() {
            return this.selectedBills.length === this.unpaidBills.length;
        },
        toggleBill(billId, isChecked) {
            isChecked ? this.selectBill(billId) : this.removeBill(billId);

            this.calculateTransaction();
        },
        selectBill(billId) {
            let selectedBill = this.unpaidBills.find((bill) => bill.id === billId);
            this.selectedBills.push(selectedBill);

            this.sortBills(this.selectedBills);
        },
        removeBill(billId) {
            this.selectedBills = this.selectedBills.filter((bill) => bill.id !== billId);
        },
        calculateFee(fixedFee, percent) {
            return this.amount > 0 ? fixedFee + (this.amount * percent) / 100 : 0;
        },
        calculateTotalAmount(fixedFee, percent) {
            return this.amount + this.calculateFee(fixedFee, percent);
        },
        calculateTransaction() {
            this.amount = 0;
            this.selectedBills.forEach((bill) => {
                this.amount += bill.amount;
            });
            this.paymentFee = this.currentPaymentMethod ? this.calculateFee(this.currentPaymentMethod.fix, this.currentPaymentMethod.rate) : 0;
            this.totalAmount = this.amount + this.paymentFee;
        },
        async processDataToMegapay() {
            try {
                let selectedBillIds = this.selectedBills.map((bill) => bill.id);
                let response = await processMegapayData.post({
                    billIds: selectedBillIds,
                    methodId: this.currentPaymentMethod.id,
                });
                console.log(response);
                return (response && response.code === CONSTANTS.RESPONSE_CODE_SUCCESS) ?
                    this.handleSuccessResponseFromMegapay(response) :
                    this.handleErrorResponseFromMegapay(response.message);
            } catch (error) {
                console.log("error ocured: ", error);
                this.handleErrorResponseFromMegapay();
            }
        },
        handleSuccessResponseFromMegapay(response) {
            return (this.currentPaymentMethod.id !== CONSTANTS.PAYMENT_METHOD_DC) ?
                this.openMegapayForm(response.data) :
                this.redirectToTransactionGuide(response.data.merTrxId)
        },
        handleErrorResponseFromMegapay(responseMessage) {
            let message = responseMessage ? responseMessage : 'Hệ thống hiện đang quá tải, vui lòng thử lại sau';
            Swal.fire({
                title: 'Lỗi!',
                text: message,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        },
        openMegapayForm(responseData) {
            console.log("into here");
            // this.megapayFormData = Object.assign(this.megapayFormData, responseData);
            const _mgpForm = document.getElementById("megapayForm");
            for (let key in responseData) {
                let inputElement = _mgpForm.querySelector(
                    `input[name="${key}"]`
                );
                inputElement ? inputElement.value = responseData[key] : null;
                // this.megapayFormData[key] = this.megapayFormData[key] !== undefined ? responseData[key] : null;
            }

            return (typeof window.openPayment === 'function') ?
                window.openPayment(1, responseData.domain) :
                this.handleErrorResponseFromMegapay("Xảy ra lỗi hệ thống, vui lòng thử lại sau");
        },
        redirectToTransactionGuide(merTrxId) {
            console.log("here instead", merTrxId);
            Inertia.visit(`/transaction/guide/${merTrxId}`);
        }
    },
});

