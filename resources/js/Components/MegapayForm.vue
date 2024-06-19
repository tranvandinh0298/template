<script setup>
import {useInvoicesStore} from "@/Stores/invoices";
const invoices = useInvoicesStore();
</script>

<script>
export default {
    computed: {
        getTransactionCallback() {
            return this.$page.props.transactionUrls.callback;
        },
        getTransactionIPN() {
            return this.$page.props.transactionUrls.ipn;
        }
    }
};
</script>

<template>
<!--    <form id="megapayForm" name="megapayForm" method="POST">-->
<!--        <input type="hidden" name="invoiceNo" :value="invoices.megapayFormData.invoiceNo" />-->
<!--        <input type="hidden" name="amount" :value="invoices.megapayFormData.amount" />-->
<!--        <input type="hidden" name="currency" value="VND" />-->
<!--        <input type="hidden" name="goodsNm" :value="invoices.megapayFormData.goodsNm" />-->
<!--        <input type="hidden" name="buyerPhone" :value="invoices.megapayFormData.buyerPhone">-->
<!--        <input type="hidden" name="buyerAddr" :value="invoices.megapayFormData.buyerAddr">-->
<!--        <input type="hidden" name="buyerCity" value="">-->
<!--        <input type="hidden" name="buyerState" value="" />-->
<!--        <input type="hidden" name="buyerPostCd" value="" />-->
<!--        <input type="hidden" name="buyerCountry" />-->
<!--        <input type="hidden" name="buyerLastNm" :value="invoices.megapayFormData.buyerLastNm">-->
<!--        <input type="hidden" name="buyerFirstNm" :value="invoices.megapayFormData.buyerFirstNm">-->
<!--        <input type="hidden" name="buyerEmail" :value="invoices.megapayFormData.buyerEmail" />-->

<!--        <input type="hidden" name="fee" value="" />-->

<!--        &lt;!&ndash; Delivery Info &ndash;&gt;-->
<!--        <input type="hidden" name="receiverFirstNm" :value="invoices.megapayFormData.receiverFirstNm">-->
<!--        <input type="hidden" name="receiverLastNm" :value="invoices.megapayFormData.receiverLastNm">-->
<!--        <input type="hidden" name="receiverPhone" :value="invoices.megapayFormData.receiverPhone">-->
<!--        <input type="hidden" name="receiverAddr" :value="invoices.megapayFormData.receiverAddr">-->
<!--        <input type="hidden" name="receiverCity" value="">-->
<!--        <input type="hidden" name="receiverState" value="" />-->
<!--        <input type="hidden" name="receiverPostCd" value="" />-->
<!--        <input type="hidden" name="receiverCountry" value="VN" />-->
<!--        <input type="hidden" name="description" :value="invoices.megapayFormData.description" />-->

<!--        &lt;!&ndash;-&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45; Main Value &#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;&ndash;&gt;-->
<!--        &lt;!&ndash; Call Back URL &ndash;&gt;-->
<!--        <input type="hidden" name="callBackUrl" :value="getTransactionCallback" />-->
<!--        &lt;!&ndash; Notify URL &ndash;&gt;-->
<!--        <input type="hidden" name="notiUrl" :value="getTransactionIPN" />-->
<!--        &lt;!&ndash; Merchant ID &ndash;&gt;-->
<!--        <input type="hidden" name="merId" :value='invoices.megapayFormData.merId' />-->
<!--        &lt;!&ndash; Encode Key &ndash;&gt;-->

<!--        <input type="hidden" name="reqDomain" value="http://localhost:8080" />-->
<!--        <input type="hidden" name="userLanguage" value="VN" />-->
<!--        <input type="hidden" name="merchantToken" :value="invoices.megapayFormData.merchantToken" />-->
<!--        <input type="hidden" name="payToken" id="payToken" :value="invoices.megapayFormData.payToken" />-->
<!--        <input type="hidden" name="timeStamp" :value="invoices.megapayFormData.timeStamp" />-->
<!--        <input type="hidden" name="merTrxId" :value="invoices.megapayFormData.merTrxId" />-->
<!--        <input type="hidden" name="windowType" value="" />-->
<!--        <input type='hidden' name='windowColor' :value="invoices.megapayFormData.windowColor" />-->
<!--        <input type="hidden" name="userFee" id="userFee" value="0" />-->
<!--        <input type="hidden" name="vaCondition" value="03" />-->
<!--        <input type="hidden" name="payType" id="payType" :value="invoices.megapayFormData.payType" />-->
<!--        <input type="hidden" name="payOption" id="payOption" value="" />-->
<!--        <input type="hidden" name="vaStartDt" value="" />-->
<!--        <input type="hidden" name="vaEndDt" value="" />-->
<!--        <input type="hidden" name="bankCode" :value="invoices.megapayFormData.bankCode" id="bankCode" />-->
<!--        <input type="hidden" name="userId" id="userId" value="abc" />-->
<!--        <input type="hidden" name="goodsAmount" id="goodsAmount" value="" />-->
<!--    </form>-->


    <form id="megapayForm" name="megapayForm" method="POST">
        <input type="hidden" name="invoiceNo" value="" />
        <input type="hidden" name="amount" value="" />
        <input type="hidden" name="currency" value="VND" />
        <input type="hidden" name="goodsNm" value="" />
        <input type="hidden" name="buyerPhone" value="">
        <input type="hidden" name="buyerAddr" value="">
        <input type="hidden" name="buyerCity" value="">
        <input type="hidden" name="buyerState" value="" />
        <input type="hidden" name="buyerPostCd" value="" />
        <input type="hidden" name="buyerCountry" />
        <input type="hidden" name="buyerLastNm" value="">
        <input type="hidden" name="buyerFirstNm" value="">
        <input type="hidden" name="buyerEmail" value="" />

        <input type="hidden" name="fee" value="" />

        <!-- Delivery Info -->
        <input type="hidden" name="receiverFirstNm" value="">
        <input type="hidden" name="receiverLastNm" value="">
        <input type="hidden" name="receiverPhone" value="">
        <input type="hidden" name="receiverAddr" value="">
        <input type="hidden" name="receiverCity" value="">
        <input type="hidden" name="receiverState" value="" />
        <input type="hidden" name="receiverPostCd" value="" />
        <input type="hidden" name="receiverCountry" value="VN" />
        <input type="hidden" name="description" value="" />

        <!------------------------------- Main Value ------------------------------>
        <!-- Call Back URL -->
        <input type="hidden" name="callBackUrl" value="http://127.0.0.1:8000/transaction/megapay-callback" />
        <!-- Notify URL -->
        <input type="hidden" name="notiUrl" value="https://127.0.0.1:8000/transaction/megapay-notify" />
        <!-- Merchant ID -->
        <input type="hidden" name="merId" value='' />
        <!-- Encode Key -->

        <input type="hidden" name="reqDomain" value="http://localhost:8080" />
        <input type="hidden" name="userLanguage" value="VN" />
        <input type="hidden" name="merchantToken" value="" />
        <input type="hidden" name="payToken" id="payToken" value="" />
        <input type="hidden" name="timeStamp" value="" />
        <input type="hidden" name="merTrxId" />
        <input type="hidden" name="windowType" value="" />
        <input type='hidden' name='windowColor' value='#1F52BE' />
        <input type="hidden" name="userFee" id="userFee" value="0" />
        <input type="hidden" name="vaCondition" value="03" />
        <input type="hidden" name="payType" id="payType" value="" />
        <input type="hidden" name="payOption" id="payOption" value="" />
        <input type="hidden" name="vaStartDt" value="" />
        <input type="hidden" name="vaEndDt" value="" />
        <input type="hidden" name="bankCode" value="" id="bankCode" />
        <input type="hidden" name="userId" id="userId" value="abc" />
        <input type="hidden" name="goodsAmount" id="goodsAmount" value="" />
    </form>
</template>

