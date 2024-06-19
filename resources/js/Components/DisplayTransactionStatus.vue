<script setup>
import CONSTANTS from "@/Stores/constants";

defineProps({
    status: Number,
    message: String,
})
</script>

<template>
    <div class="transaction__result">
        <div
            class="result__icon"
            :class="{
                'result__icon--refresh': status === CONSTANTS.TRANS_STATUS_PENDING,
                'result__icon--success' : status === CONSTANTS.TRANS_STATUS_SUCCESS,
                'result__icon--error': status === CONSTANTS.TRANS_STATUS_FAILED,
                'result__icon--loading': status === CONSTANTS.TRANS_STATUS_WAITING
             }"
        >
            <img v-if="status === CONSTANTS.TRANS_STATUS_SUCCESS" id="icon--success"
                 src="@/../images/common/icon_success.png"
                 alt="">
            <img v-else-if="status === CONSTANTS.TRANS_STATUS_FAILED" id="icon--error"
                 src="@/../images/common/icon_error.png"
                 alt="">
            <img v-else-if="status === CONSTANTS.TRANS_STATUS_PENDING" id="icon--refresh"
                 src="@/../images/common/icon_refresh.png"
                 alt="">
            <img v-else-if="status === CONSTANTS.TRANS_STATUS_WAITING" id="icon--loading"
                 src="@/../images/common/icon_loading.png"
                 alt="">
        </div>
        <h4 class="text-uppercase text-center m-0 font-weight-bold">
            <template v-if="status === CONSTANTS.TRANS_STATUS_PENDING">
                Giao dịch đang chờ xử lý, vui lòng đừng thanh toán lại
            </template>

            <template v-else-if="status === CONSTANTS.TRANS_STATUS_SUCCESS">
                Giao dịch thành công
            </template>

            <template v-else-if="status === CONSTANTS.TRANS_STATUS_FAILED">
                Giao dịch thất bại
            </template>

            <template v-else-if="status === CONSTANTS.TRANS_STATUS_WAITING">
                Giao dịch chờ thanh toán
            </template>
        </h4>
        <p v-if="message" class="text-center">{{ message }}</p>
    </div>
</template>

<style scoped>
.transaction__result {
    min-height: 160px;
    max-width: 60%;
    margin: 0 auto;
    padding-top: 24px;
    padding-bottom: 4px;
}

.result__icon {
    display: block;
    width: 68px;
    height: 68px;
    margin: 0 auto 20px;
}

.result__icon img {
    display: none;
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.result__icon.result__icon--success img,
.result__icon.result__icon--error img,
.result__icon.result__icon--refresh img,
.result__icon.result__icon--loading img {
    display: none;
}

.result__icon.result__icon--success #icon--success,
.result__icon.result__icon--error #icon--error,
.result__icon.result__icon--refresh #icon--refresh,
.result__icon.result__icon--loading #icon--loading {
    display: block;
}

</style>
