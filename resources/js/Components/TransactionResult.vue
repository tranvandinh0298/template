<script setup>
import Modal from "@/Components/Modal.vue";
import DisplayTransactionStatus from "@/Components/DisplayTransactionStatus.vue";
import DisplayMoney from "@/Components/DisplayMoney.vue";

defineProps({
    clientTransactionDTO: Object
});
</script>

<template>
    <Modal :show="clientTransactionDTO != null" title="Kết quả giao dịch" @close-modal="clientTransactionDTO = null">
        <div class="transaction">
            <DisplayTransactionStatus :status="clientTransactionDTO.status" :message="clientTransactionDTO.mgpMsg"/>
            <div class="transaction__info">
                <table class="table table-borderless">
                    <tbody>
                    <tr>
                        <td><span>Bill ID (mã học sinh online)</span></td>
                        <td><span>{{ clientTransactionDTO.contractNo }}</span></td>
                    </tr>
                    <tr>
                        <td><span>Tên học sinh</span></td>
                        <td><span>{{ clientTransactionDTO.customerName }}</span></td>
                    </tr>
                    <tr>
                        <td><span>Lớp</span></td>
                        <td><span>{{ clientTransactionDTO.customerAddress }}</span></td>
                    </tr>
                    <tr>
                        <td><span>Mã giao dịch</span></td>
                        <td><span>{{ clientTransactionDTO.trxId }}</span></td>
                    </tr>
                    <tr>
                        <td><span>Danh sách các tháng đóng học phí</span></td>
                        <td>
                            <span>{{ clientTransactionDTO.clientTransactionDetailDTOs.map((detail) => detail.name).join(", ") }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td><span>Tổng học phí</span></td>
                        <td><span><DisplayMoney :amount="clientTransactionDTO.amount"/></span></td>
                    </tr>
                    <tr>
                        <td><span>Phí thu hộ</span></td>
                        <td><span><DisplayMoney
                            :amount="clientTransactionDTO.totalAmount - clientTransactionDTO.amount"/></span>
                        </td>
                    </tr>
                    <tr>
                        <td><span>Tổng</span></td>
                        <td>
                            <h5 class="font-weight-bold">
                                <DisplayMoney :amount="clientTransactionDTO.totalAmount"/>
                            </h5>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </Modal>
</template>

<style scoped>
.transaction {
}

.transaction__info {
    padding: 20px 4px 0;
}

.transaction__result h4 + p {
    margin-top: 5px;
    margin-bottom: 0;
}

.transaction__info span {
    color: var(--text-color);
    font-weight: 600;
}

.transaction__info p,
h4,
h5 {
    margin: 0;
}

</style>
