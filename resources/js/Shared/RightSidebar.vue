<script>
import SectionCard from "@/Components/SectionCard";
import PaymentMethod from "@/Components/PaymentMethod";
import DisplayMoney from "@/Components/DisplayMoney.vue";

export default {
    components: {
        SectionCard,
        PaymentMethod,
        DisplayMoney
    },
    data() {
        return {
        }
    }
}


</script>

<script setup>
import {useInvoicesStore} from "@/Stores/invoices";

const invoices = useInvoicesStore();
</script>

<template>
    <section class="col col-md-3 col-12">
        <SectionCard>
            <template #header>
                <div class="flex items-center">
                    <img src="@/../images/common/icon_payment_info_with_background.png" alt="">
                    <a href="javascript:void(0)"> Thông tin thanh toán </a>
                </div>
            </template>
            <template #body>
                <div class="invoice">
                    <p class="invoice__title">Phương thức thanh toán</p>
                    <div v-if="invoices.currentPaymentMethod !== undefined || invoices.currentPaymentMethod != null">
                        <PaymentMethod :method="invoices.currentPaymentMethod" :showFee="false"/>
                    </div>
                    <span v-else class="mx-2 badge badge-pill badge-danger">Chưa chọn phương thức thanh toán</span>
                </div>
                <div class="invoice">
                    <p class="invoice__title">Danh sách các khoản phí</p>
                    <ul class="invoice__list" id="block-payment-list">
                        <template v-if="invoices.selectedBills.length > 0" v-for="bill in invoices.selectedBills">
                            <li v-if="bill.details.length > 0" v-for="detail in bill.details">
                                <p>{{ detail.itemName }}</p>
                                <p>
                                    <DisplayMoney :amount="detail.itemAmount"/>
                                </p>
                            </li>
                            <li v-else>
                                <p>{{ bill.name }}</p>
                                <p>
                                    <DisplayMoney :amount="bill.amount"/>
                                </p>
                            </li>
                        </template>
                        <li v-else>
                            <span class="badge badge-pill badge-danger">Chưa chọn khoản học phí nào</span>
                        </li>
                    </ul>
                    <ul class="invoice__list summary">
                        <li>
                            <p class="">Phí thu hộ</p>
                            <p id="payment-fee" class="">
                                <DisplayMoney :amount="invoices.paymentFee"/>
                            </p>
                        </li>
                        <li>
                            <p class="font-bold">Tổng</p>
                            <p id="grand-total" class="font-bold text-xl">
                                <DisplayMoney :amount="invoices.totalAmount"/>
                            </p>
                        </li>
                    </ul>
                    <button @click="invoices.processDataToMegapay" id="payment-submit" class="button btn-block text-uppercase full-width">Thanh
                        toán
                    </button>
                </div>
            </template>
        </SectionCard>
    </section>
</template>

<style scoped>
.invoice {

}

.invoice + .invoice {
    margin-top: 24px;
}

.invoice__title {
    display: block;
    flex-basis: 100%;
    font-size: 14px;
    color: var(--text-color);
    margin: 0px 12px 8px 8px;
    background: #F8F8F8;
    font-weight: 600;
    padding: 4px 8px;
    border-radius: 8px;
}

.invoice__list {
    padding: 0 14px;
    margin-top: 12px;
    margin-bottom: 0;
}

.invoice__list.summary {
    overflow: auto;
    color: var(--primary-color);
    margin-bottom: 26px;
}

.invoice__list li {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 14px;
    font-weight: 400;
}

.invoice__list li + li {
    margin-top: 16px;
}

.invoice__list li:first-child {

}

.invoice__list p {
    margin-bottom: 0;
    font-size: 16px;
}

.invoice__list.summary li:first-child {
    border-top: 1px solid var(--primary-color);
    padding-top: 20px;
}

#grand-total {
    font-size: 20px;
}


</style>
