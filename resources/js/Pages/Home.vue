<script setup>
import {useInvoicesStore} from "@/Stores/invoices";
import {onMounted, ref} from 'vue';

const invoices = useInvoicesStore();

// Initialize Pinia store with initial state from Laravel
let props = defineProps({
    customerInfo: Object,
    clientTransactionDTO: {
        type: [Object, null],
        required: false,
    },
});

// Initialize Pinia store with initial state from Laravel
onMounted(() => {
    if (props.customerInfo) {
        let bills = props.customerInfo.billDTOs;
        let paymentMethods = props.customerInfo.merchantDTO.paymentMethodDTOs;
        invoices.initialData(bills, paymentMethods);
    }
});

const showBtnDelete = ref(false);

</script>

<script>
import DefaultLayout from "@/Layouts/DefaultLayout";
import RightSidebar from "@/Shared/RightSidebar";
import LeftSidebar from "@/Shared/LeftSidebar";
import SectionCard from "@/Components/SectionCard.vue";
import Checkbox from "@/Components/Checkbox.vue";
import Payment from "@/Components/Payment.vue";
import Invoices from "@/Components/Invoices.vue";
import TransactionResult from "@/Components/TransactionResult.vue";

export default {
    components: {
        RightSidebar,
        LeftSidebar,
        SectionCard,
        Checkbox,
        Payment,
        Invoices,
        TransactionResult
    },
    layout: DefaultLayout,
    data() {
        return {}
    }
};
</script>

<template>
    <!-- Content -->
    <div class="content">
        <div class="content__container">
            <div class="main-content">
                <div class="row">
                    <left-sidebar/>

                    <section class="col col-md-6 col-12">
                        <SectionCard>
                            <template #header>
                                <div class="flex items-center">
                                    <img src="@/../images/common/icon_list_with_background_2.png"
                                         alt="">
                                    <a href="javascript:void(0);"> Danh sách các tháng đóng học phí </a>
                                </div>
                            </template>
                            <template #body>
                                <Invoices :bills="props.customerInfo.billDTOs"/>
                            </template>
                        </SectionCard>
                        <SectionCard>
                            <template #header>
                                <div class="flex items-center">
                                    <img src="@/../images/common/icon_payment_method_with_background.png"
                                         alt="">
                                    <a href="javascript:void(0);"> Phương thức thanh toán </a>
                                </div>
                                <a @click="showBtnDelete = true" class="btn-edit" > <i
                                    class="fas fa-pen"></i> <span>Chỉnh sửa</span> </a>
                            </template>
                            <template #body>
                                <Payment :show-delete-btn="showBtnDelete" :payment-methods="invoices.paymentMethods" id="selected-payment-methods"
                                         :show-fee="true" :show-more="true"/>
                            </template>
                        </SectionCard>
                    </section>

                    <right-sidebar/>
                </div>
            </div>
        </div>
    </div>
    <!-- /Content -->

    <TransactionResult :clientTransactionDTO="clientTransactionDTO" />
</template>
