<script>
import DataTable from 'datatables.net-dt';
import DisplayMoney from "@/Components/DisplayMoney.vue";
import PaymentStatus from "@/Components/PaymentStatus.vue";
import Checkbox from "@/Components/Checkbox.vue";

export default {
    components: {
        DisplayMoney,
        PaymentStatus,
        Checkbox
    }
};
</script>

<script setup>
import {ref, onMounted, watch, nextTick} from 'vue';
import {useInvoicesStore} from "@/Stores/invoices";

onMounted(() => {
    let table = new DataTable('#tuition-datatable', {
        language: {
            oPaginate: {
                sFirst: '<i class="fa-solid fa-angles-left"></i>',
                sPrevious: '<i class="fa fa-chevron-left">',
                sNext: '<i class="fa fa-chevron-right">',
                sLast: '<i class="fa-solid fa-angles-right"></i>',
            },
            sInfo: "Hiển thị từ _START_ đến _END_ trong tổng số _TOTAL_ dòng",
        },
        paging: true,
        pageLength: 1,
        fixedHeader: true,
        bProcessing: true,
        bLengthChange: false,
        bSort: false,
        serverSide: false,
        searching: false,
        ordering: false,
        initComplete: (settings, json) => {
            const pagination = document.querySelector(".dt-paging");
            const paginationRow = pagination.closest(".dt-layout-row");
            document.querySelector(".table-pagination").appendChild(paginationRow);
        },
    });
});

const invoices = useInvoicesStore();

defineProps({
    bills: Array
});
</script>

<template>
    <div class="invoice">
        <div class="table-responsive">
            <table class="table" id="tuition-datatable">
                <thead>
                <tr>
                    <th>
                        <label for="select-all" class="label">
                            <input type="checkbox" :checked="invoices.isAllUnpaidBillsSelected()" @change="invoices.toggleAllBills($event.target.checked)" id="select-all" name="">
                            <div class='checkmark'></div>
                        </label>
                    </th>
                    <th><span>Tháng</span></th>
                    <th><span>Số tiền</span></th>
                    <th><span>Trạng thái thanh toán</span></th>
                    <th><span>Ngày thanh toán</span></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="bill in bills" :bill-id="bill.id">
                    <td>
                        <label class="label">
                            <input type="checkbox" :checked="invoices.isBillSelected(bill.id)" @change="invoices.toggleBill(bill.id, $event.target.checked)" :id="bill.id"/>
                            <div class="checkmark"></div>
                        </label>
                    </td>
                    <td>
                        <span>{{ bill.name }}</span>
                    </td>
                    <td>
                        <DisplayMoney :amount="bill.amount"/>
                    </td>
                    <td>
                        <PaymentStatus :status="!!bill.status"/>
                    </td>
                    <td>
                        <span>{{ bill.paymentDate }}</span>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="table-pagination"></div>
    </div>
</template>

<style scoped>

.invoice .table {
    color: var(--text-color);
}

.invoice .table-pagination {
    margin-bottom: 10px;
}

/* width */
.invoice .table-responsive::-webkit-scrollbar {
    width: 16px;
    height: 6px;
}

/* Track */
.invoice .table-responsive::-webkit-scrollbar-track {
    background: transparent;
}

/* Handle */
.invoice .table-responsive::-webkit-scrollbar-thumb {
    background: #DEDEDE;
    border-radius: 10px;
    height: 6px;
    width: 40px;
}

/* Handle on hover */
.invoice .table-responsive::-webkit-scrollbar-thumb:hover {
    background: #c1c1c1;
}

.invoice label {
    display: flex;
    width: 100%;
}

.invoice .table tr {}

.invoice .table th,
.invoice .table td {
    padding: 16px;
    white-space: nowrap;
}

.invoice .table th {
    border: 0;
    font-size: 14px;
    vertical-align: middle;
    background-color: #F8F8F8;
}

.invoice .table th span {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    -webkit-justify-content: flex-start;
    width: 100%;
    height: 100%;
}

.invoice .table th input[type=checkbox] {
    border: 1px solid #dddddd;
    outline: none;
}

.invoice .table td {
    font-size: 16px;
    border-top: 0.5px solid #EDEDED;
}



/* -------------------- Checkmark---------------------- */
.label input[type="checkbox"],
.label input[type="radio"] {
    display: none;
    cursor: none;
}

.invoice .label {
    width: 100%;
    height: 100%;
}

.checkmark {
    display: flex;
    align-items: center;
    justify-content: center;
    -webkit-justify-content: center;
    width: 24px;
    height: 24px;
    position: relative;
}

.checkmark::before {
    content: "";
    display: block;
    width: 18px;
    height: 18px;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    position: absolute;
    background: transparent;
    border: 1px solid #b1b1b1;
    border-radius: 4px;
    z-index: 10;
}

input[type="checkbox"]:is(:checked)~.checkmark.checkmark::before,
input[type="radio"]:is(:checked)~.checkmark.checkmark::before,
.active .label .checkmark.checkmark::before,
.active .label .checkmark.checkmark::before {
    border-color: var(--primary-color);
    background-color: var(--primary-color);
}

input[type="checkbox"]:is(:disabled)~.checkmark.checkmark::before,
input[type="radio"]:is(:disabled)~.checkmark.checkmark::before {
    background-color: #b1b1b1;
    border-color: #b1b1b1;
}

.checkmark::after {
    font-family: 'Font Awesome 5 Free';
    content: '\f058';
    font-size: 12px;
    display: none;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white;
    z-index: 11;
}

input[type="checkbox"]:is(:checked)~.checkmark::after,
input[type="checkbox"]:is(:disabled)~.checkmark::after,

.active .label .checkmark::after {
    display: block;
}


/* -------------------- /Checkmark---------------------- */

@media screen and (max-width: 768px) {
    .invoice .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        -ms-overflow-style: -ms-autohiding-scrollbar;
    }

    .invoice .table td {
        white-space: nowrap;
    }

    .invoice .table tr {
        margin-left: 60px;
    }

    .invoice .table th:first-child,
    .invoice .table td:first-child {
        position: sticky;
        left: 0;
        z-index: 10;
        background: #fff;
    }

    .invoice .table th:first-child::before,
    .invoice .table td:first-child::before {
        content: "";
        display: block;
        position: absolute;
        top: 0;
        right: 0;
        width: 3px;
        height: 100%;
        box-shadow: -2px 0px 3px 0px rgba(0, 0, 0, 0.10);
        -moz-box-shadow: -2px 0px 3px 0px rgba(0, 0, 0, 0.10);
        -webkit-box-shadow: -2px 0px 3px 0px rgba(0, 0, 0, 0.10);
        z-index: 11;

    }

    .invoice .table td:first-child {
        background: #fff;
    }

    .invoice .table th:first-child::after {
        font-family: "Font Awesome\ 5 Free";
        content: "\f0d9";
        position: absolute;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
    }
}

</style>

