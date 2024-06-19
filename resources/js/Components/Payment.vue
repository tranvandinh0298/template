<script>
import Checkbox from "@/Components/Checkbox.vue";
import PaymentMethod from "@/Components/PaymentMethod.vue";
import Modal from "@/Components/Modal.vue";
import MegapayForm from "@/Components/MegapayForm.vue";

export default {
    components: {
        Checkbox,
        PaymentMethod,
        Modal,
        MegapayForm
    },
    data() {
        return {
        }
    },
    methods: {
    }
};

</script>

<script setup>

import {useInvoicesStore} from "@/Stores/invoices";

import {ref} from "vue";

defineProps({
    id: String,
    title: String,
    showFee: Boolean,
    showMore: Boolean,
    showDeleteBtn: Boolean
});

const invoices = useInvoicesStore();

const showModal = ref(false);

const handleSelectingPaymentMethod = (paymentMethodId) => {
    invoices.selectPaymentMethod(paymentMethodId);
    showModal.value = false;
}

const handleDeletePaymentMethodOnDisplay = (paymentMethod) => {
    paymentMethod.onDisplay = false;
    if (paymentMethod.id === invoices.currentPaymentMethod.id) {
        invoices.selectPaymentMethod();
    }
}
</script>


<template>
    <div class="payment" :id="id">
        <p v-show="title" class="payment__title">{{ title }}</p>
        <ul>
            <li class="w-full flex justify-between items-center font-[400] text-sm"
                v-for="paymentMethod in invoices.onDisplayPaymentMethods">
                <Checkbox @click="invoices.selectPaymentMethod(paymentMethod.id)"
                          :is-active="invoices.isCurrentPaymentMethod(paymentMethod.id)" :is-circle="true"
                          :show-mark="true">
                    <PaymentMethod :method="paymentMethod" :show-fee="showFee"/>
                </Checkbox>
                <button v-show="showDeleteBtn && !paymentMethod.isRequired" class="payment__remove" @click="handleDeletePaymentMethodOnDisplay(paymentMethod)">
                    <img src="@/../images/common/icon_trash_can.png" alt="" >
                </button>
            </li>
        </ul>
        <div class="show-more" v-show="showMore">
            <button @click="showModal = true" class="btn-more" >
                <div class="more__label">
                    <img
                        src="@/../images/common/icon_plus.png"
                        alt="">
                    <div class="more__info">
                        <p class="uppercase mb-0">Thêm phương thức thanh toán</p>
                        <p class="more__fee mb-0">Phí thu hộ: <span class="font-bold">cao hơn 3,300đ/giao dịch</span>
                        </p>
                    </div>
                </div>
                <div class="more__images">
                    <img v-for="image in invoices.availablePaymentMethodImgs" :src="image" alt="#"/>
                </div>
            </button>

            <Modal :show="showModal" title="Các phương thức thanh toán khác" @close-modal="showModal = false">
                <template #default>
                    <div class="block">
                        <template v-if="invoices.availableEWPaymentMethods.length > 0">
                            <p class="methods__title">Ví điện tử</p>
                            <ul class="methods">
                                <li v-for="paymentMethod in invoices.availableEWPaymentMethods">
                                    <Checkbox @click="handleSelectingPaymentMethod(paymentMethod.id)"
                                              :show-mark="false">
                                        <PaymentMethod :method="paymentMethod" :showFee="true"/>
                                    </Checkbox>
                                </li>
                            </ul>
                        </template>
                        <template v-if="invoices.availableICPaymentMethods.length > 0">
                            <p class="methods__title">Thanh toán thẻ</p>
                            <ul class="methods">
                                <li v-for="paymentMethod in invoices.availableICPaymentMethods">
                                    <Checkbox @click="handleSelectingPaymentMethod(paymentMethod.id)"
                                              :show-mark="false">
                                        <PaymentMethod :method="paymentMethod" :showFee="true"/>
                                    </Checkbox>
                                </li>
                            </ul>
                        </template>
                        <template v-if="invoices.availableQRPaymentMethods.length > 0">
                            <p class="methods__title">Mã QR</p>
                            <ul class="methods">
                                <li v-for="paymentMethod in invoices.availableQRPaymentMethods">
                                    <Checkbox @click="handleSelectingPaymentMethod(paymentMethod.id)"
                                              :show-mark="false">
                                        <PaymentMethod :method="paymentMethod" :showFee="true"/>
                                    </Checkbox>
                                </li>
                            </ul>
                        </template>
                        <template v-if="invoices.availablePLPaymentMethods.length > 0">
                            <p class="methods__title">Trả sau</p>
                            <ul class="methods">
                                <li v-for="paymentMethod in invoices.availablePLPaymentMethods">
                                    <Checkbox @click="handleSelectingPaymentMethod(paymentMethod.id)"
                                              :show-mark="false">
                                        <PaymentMethod :method="paymentMethod" :showFee="true"/>
                                    </Checkbox>
                                </li>
                            </ul>
                        </template>
                    </div>
                </template>
            </Modal>
        </div>
        <MegapayForm />
    </div>
</template>

<style>
.payment {
    padding-top: 6px;
    padding-bottom: 6px;
    color: var(--text-color);
}

.payment + .payment {
    margin-top: 10px;
}

.payment ul {
}

.payment ul li {
}

.payment ul li + li {
    margin-top: 16px;
}

.payment__remove {
    display: flex;
    margin-left: 16px;
    justify-content: center;
    align-items: center;
    height: 76px;
    width: 76px;
    border-radius: 12px;
    background: #FFF4F4;
    border: 1px solid #FFF0F0;
    transition: all 0.2s linear;
}

.payment__remove:hover {
    background-color: #efefef;
}

.payment__remove img {
    max-width: 40%;
    height: 100%;
    object-fit: contain;
}

.methods__title {
    color: var(--primary-color);
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 4px;
}

.methods+.methods__title {
    margin-top: 14px;
}

.show-more {
    margin-top: 16px;
}

.btn-more {
    display: flex;
    width: 100%;
    justify-content: space-between;
    align-items: center;
    border-radius: 12px;
    border: 1px solid #EDEDED;
    padding: 10px 16px;
    cursor: pointer;
    background-color: var(--primary-color);
    color: white;
}

.more__label {
    display: flex;
    align-items: center;
    width: auto;
    padding: 0 14px 0 16px;
    height: auto;
}

.more__images {
    display: flex;
    align-items: center;
    width: auto;
    height: 44px;
}

.more__label img, .more__images img {
    display: block;
    width: auto;
    max-width: 100%;
    height: auto;
    max-height: 100%;
    object-fit: contain;
    margin-right: 12px;
}

.more__images img {
    margin-right: 0;
    height: 32px;
}

.more__images img + img {
    margin-left: 5px;
}

@media screen and (max-width: 768px) {
    .btn-more {
        padding-top: 14px;
        padding-bottom: 14px;
        flex-wrap: wrap;
        flex-direction: column;
    }

    .more__label, .more__images {
        flex:1;
        padding: 0 14px;
    }

    .more__images {
        margin-top: 12px;
        height: auto;
        flex-wrap: wrap;
    }

    .more__images img {
        margin-bottom: 5px;
    }

    .more__images img:first-child{
        margin-right: 5px;
    }

    .more__images img + img {
        margin-left: unset;
        margin-right: 5px;
    }

    .more__info p {
        font-size: 14px;
    }
    .more__info p:last-child {
        font-size: 12px;
    }
}

</style>
