<script>
import {PaymentMethod} from "@/Components/PaymentMethod.vue";
import {Checkbox} from "@/Components/Checkbox.vue";

export default {
    components: {
        PaymentMethod,
        Checkbox
    }
}
</script>

<script setup>
import {useInvoicesStore} from "@/Stores/invoices";

const invoices = useInvoicesStore();
</script>

<template>
    <!-- More payment methods modal -->
    <div class="modal" id="more-payment-method">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Phương thức thanh toán khác</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="payment" id="available-payment-methods">
                        <template v-if="invoices.availableEWPaymentMethods.length > 0">
                            <p class="methods__title">Ví điện tử</p>
                            <ul class="methods">
                                <li v-for="paymentMethod in invoices.availableEWPaymentMethods">
                                    <Checkbox @click="invoices.selectPaymentMethod(paymentMethod.id)"
                                              :show-mark="false">
                                        <PaymentMethod :method="paymentMethod" :show-fee="true"/>
                                    </Checkbox>
                                </li>
                            </ul>
                        </template>
                        <template v-if="invoices.availableICPaymentMethods.length > 0">
                            <p class="methods__title">Thanh toán thẻ</p>
                            <ul class="methods">
                                <li v-for="paymentMethod in invoices.availableICPaymentMethods">
                                    <Checkbox @click="invoices.selectPaymentMethod(paymentMethod.id)"
                                              :show-mark="false">
                                        <PaymentMethod :method="paymentMethod" :show-fee="true"/>
                                    </Checkbox>
                                </li>
                            </ul>
                        </template>
                        <template v-if="invoices.availableQRPaymentMethods.length > 0">
                            <p class="methods__title">Mã QR</p>
                            <ul class="methods">
                                <li v-for="paymentMethod in invoices.availableQRPaymentMethods">
                                    <Checkbox @click="invoices.selectPaymentMethod(paymentMethod.id)"
                                              :show-mark="false">
                                        <PaymentMethod :method="paymentMethod" :show-fee="true"/>
                                    </Checkbox>
                                </li>
                            </ul>
                        </template>
                        <template v-if="invoices.availablePLPaymentMethods.length > 0">
                            <p class="methods__title">Trả sau</p>
                            <ul class="methods">
                                <li v-for="paymentMethod in invoices.availablePLPaymentMethods">
                                    <Checkbox @click="invoices.selectPaymentMethod(paymentMethod.id)"
                                              :show-mark="false">
                                        <PaymentMethod :method="paymentMethod" :show-fee="true"/>
                                    </Checkbox>
                                </li>
                            </ul>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
