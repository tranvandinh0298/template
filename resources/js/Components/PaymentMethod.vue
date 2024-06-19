<script setup>
import {useInvoicesStore} from "@/Stores/invoices";
import DisplayMoney from "@/Components/DisplayMoney.vue";

defineProps({
    showFee: Boolean,
    method: {
        id: Number,
        priority: Number,
        code: String,
        name: String,
        mgpCode: String,
        mgpBankCode: String,
        images: Array,
        fix: Number,
        rate: Number,
        onDisplay: Boolean,
        required: Boolean,
    },
});

const invoices = useInvoicesStore();
</script>

<template>
    <div class="method"  :data-id="method.id">
        <div class="method__img">
            <img v-for="image in method.images" :src="image" :alt="method.name">
        </div>
        <div class="method__info">
            <p class="method__title font-bold">{{ method.name }}</p>
            <p class="method__fee" v-if="showFee">Phí thu hộ:
                <span class="txt-primary font-bold"><DisplayMoney :amount="invoices.calculateFee(method.fix, method.rate)" />/giao dịch</span>
            </p>
        </div>
        <p v-if="showFee" class="method__grandtotal txt-primary font-bold"><DisplayMoney :amount="invoices.calculateTotalAmount(method.fix, method.rate)" /></p>
    </div>
</template>

<style scoped>
.method {
    display: flex;
    flex: 1;
    width: 100%;
    align-items: center;
    padding: 0 14px 0 16px;
}

.method__img {
    display: flex;
    align-items: center;
    width: auto;
    height: 44px;
    margin-right: 12px;
}

.method__img img {
    display: block;
    width: auto;
    max-width: 100%;
    height: auto;
    max-height: 100%;
    object-fit: contain;
}

.method__img img + img {
    margin-left: 5px;
}

.method p {
    margin-bottom: 0;
}

.method__info {
    flex: 1;
}

.method__title {
}

.method__fee {
    font-size: 14px;
}

.method__grandtotal {
    font-size: 20px;
}

.hide-method-img .method__img {
    display: none;
}

@media screen and (max-width: 768px) {
    .method {
        padding: 0 12px;
    }
    .method p {
        font-size: 14px;
    }
    .method__grandtotal {
        display: none;
    }
}
</style>
