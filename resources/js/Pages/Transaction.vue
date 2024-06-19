<script>
import DefaultLayout from "@/Layouts/DefaultLayout";
import LeftSidebar from "@/Shared/LeftSidebar.vue";
import SectionCard from "@/Components/SectionCard.vue";
import PaymentMethod from "@/Components/PaymentMethod.vue";
import RightSidebarForTransaction from "@/Shared/StaticRightSidebar.vue";

export default {
    components: {
        LeftSidebar,
        SectionCard,
        PaymentMethod,
        RightSidebarForTransaction,
    },
    layout: DefaultLayout
};
</script>

<script setup>
import {useInvoicesStore} from "@/Stores/invoices";
import DisplayMoney from "@/Components/DisplayMoney.vue";
import TransactionNote from "@/Components/TransactionNote.vue";

const invoices = useInvoicesStore();

// Initialize Pinia store with initial state from Laravel
let props = defineProps({
    customerInfo: Object,
    clientTransactionDTO: Object
});

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
                                    <a href="javascript:void(0);"> Hướng dẫn chuyển khoản </a>
                                </div>
                            </template>
                            <template #body>
                                <div class="guide">
                                    <p>Quý khách vui lòng chuyển khoản theo hướng dẫn dưới đây để thanh toán hóa
                                        đơn:</p>
                                    <ul>
                                        <li>
                                            <div class="guide__step">
                                                <img src="@/../images/common/icon_guide_with_background.png" alt="">
                                                <div class="guide__note">
                                                    <p>Bước 1:</p>
                                                    <p>Mở ứng dụng Ngân hàng của bạn</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="guide__step">
                                                <img src="@/../images/common/icon_scan_qr_with_background.png" alt="">
                                                <div class="guide__note">
                                                    <p>Bước 2:</p>
                                                    <p>Quét mã QR dưới đây</p>
                                                </div>
                                                <div class="va">
                                                    <div class="va__content">
                                                        <div class="qr">
                                                            <div class="qr__wrapper">
                                                                <ul class="qr__list">
                                                                    <li style="margin-bottom:5px;">
                                                                        <img src="@/../images/qr/viet_qr.svg" alt="">
                                                                    </li>
                                                                    <li>
                                                                        <img src="@/../images/qr/napas_247.svg" alt="">
                                                                    </li>
                                                                </ul>
                                                                <div class="qr__area">
                                                                    <img
                                                                        :src="clientTransactionDTO.vaQrCode"
                                                                        alt="">
                                                                </div>
                                                            </div>
                                                            <a :href="clientTransactionDTO.vaQrCode"
                                                               class="qr__download txt-weight-400"
                                                               download="Mã QR thông tin chuyển khoản">
                                                                <img src="@/../images/common/icon_download.png" alt="">
                                                                Tải mã QR điện thoại
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <p class="va__option">Hoặc</p>
                                                    <div class="va__content">
                                                        <p>Nhập thông tin chuyển khoản như bên dưới</p>
                                                        <div class="bank">
                                                            <ul class="info__list">
                                                                <li>
                                                                    <span>Ngân hàng</span>
                                                                    <span>{{clientTransactionDTO.bankName}}</span>
                                                                </li>
                                                                <li>
                                                                    <span>Số tài khoản</span>
                                                                    <span>{{clientTransactionDTO.vaNumber}}</span>
                                                                </li>
                                                                <li>
                                                                    <span>Số tiền</span>
                                                                    <span><DisplayMoney :amount="clientTransactionDTO.totalAmount" /></span>
                                                                </li>
                                                                <li>
                                                                    <span>Nội dung chuyển khoản</span>
                                                                    <span>{{clientTransactionDTO.vaContent}}</span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="guide__step">
                                                <img src="@/../images/common/icon_complete_payment_with_background.png"
                                                     alt="">
                                                <div class="guide__note">
                                                    <p>Bước 3:</p>
                                                    <p>Hoàn tất thanh toán</p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <TransactionNote />
                            </template>
                        </SectionCard>
                    </section>

                    <right-sidebar-for-transaction :clientTransactionDTO="clientTransactionDTO" />
                </div>
            </div>
        </div>
    </div>
    <!-- /Content -->
</template>

<style scoped>
.guide {
}

.guide p {
    margin-bottom: 0;
}

.guide > p {
    font-weight: 600;
    margin-bottom: 16px;
}

.guide ul {
}

.guide > ul > li {
    padding: 14px 20px;
    background: #F8F8F8;
    border-radius: 16px;
}

.guide > ul > li + li {
    margin-top: 10px;
}

.guide__step {
    position: relative;
}

.guide__step > img {
    max-width: 50px;
    max-height: 50px;
    height: auto;
    object-fit: contain;
    top: 0;
    left: 0;
    position: absolute;
}

.guide__step > img ~ div {
    padding-left: 70px;
}

.guide__note p:first-child {
    font-weight: 600;
}

.va {
    display: flex;
    justify-content: space-between;
    -webkit-justify-content: space-between;
    align-items: center;
    padding-top: 16px;
}

.va__content {
    flex-basis: 40%;
    -webkit-flex-basis: 40%;
}

.va p {
    font-size: 14px;
    font-weight: 400;
    margin-bottom: 35px;
}

.guide .va p {
    font-size: 16px;
    margin-bottom: 16px;
}

.va .va__option {
    display: flex;
    align-items: flex-start;
    justify-content: center;
    -webkit-justify-content: center;
    height: 100%;
    align-self: center;
    position: relative;
}

.guide .va .va__option {
    margin: 0;
}

.qr {
    display: block;
}

.qr__list {
    display: flex;
    justify-content: center;
    -webkit-justify-content: center;
    align-items: center;
    overflow: auto;
    margin-bottom: 0;
    padding-left: 0;
    height: auto;
    position: relative;
}

.qr__list li {
    display: block;
    height: auto;
    position: relative;
}

.qr__list li + li {
    margin-left: 16px;
}

.qr__list li + li::before {
    content: "";
    display: block;
    width: 1px;
    height: 12px;
    background: #1B417F;
    position: absolute;
    top: 0;
    left: -8px;
    transform: translateY(50%);
}

.qr__list li img {
    display: block;
    height: 20px;
    width: auto;
    object-fit: contain;
}

.qr__wrapper {
    padding: 14px 12px;
    border-radius: 16px;
    background: white;
}

.qr--large .qr__item img {
}

.qr__area {
    display: flex;
    align-items: center;
    justify-content: center;
    -webkit-justify-content: center;
    width: 248px;
    height: 248px;
    margin: 0 auto;
    border: 3px solid;
    border-image: url("@/../images/qr/qr-border.png") 2 round;
}

.guide .qr__area {
    width: 210px;
    height: 210px;
}

.qr__area img {
    display: block;
    width: 100%;
    height: auto;
    object-fit: contain;
}

.qr__download {
    display: flex;
    justify-content: center;
    -webkit-justify-content: center;
    align-items: center;
    width: fit-content;
    text-align: center;
    padding: 9px 50px;
    font-size: 12px;
    line-height: 18px;
    text-decoration: none;
    font-weight: 400;
    background-color: #E0F6FF;
    color: var(--primary-color);
    margin: 12px auto 0;
    border-radius: 16px;
}

.qr__download:hover,
.qr__download:visited {
    text-decoration: underline;
    color: var(--primary-color);
}

.qr__download:active {
    color: var(--primary-color);
}

.qr__download img {
    margin-right: 10px;
}

.bank {
}

.info__list {
    padding-left: 0;
    list-style: none;
}

.info__list li {
    display: flex;
    align-items: center;
    justify-content: space-between;
    -webkit-justify-content: space-between;
    padding: 14px 20px;
    font-size: 12px;
}

.guide .info__list li {
    padding: 14px 18px;
    background: white;
    border-radius: 8px;
}

.info__list li + li {
    margin-top: 10px;
}

.guide .info__list li + li {
    margin-top: 6px;
}

.info__list li span:first-child {
    text-align: left;
}

.info__list li span:last-child {
    text-align: right;
}

.info__list li span:nth-child(even),
.bank .bank__note {
    font-size: 16px;
    color: var(--primary-color);
    font-weight: 700;
}

.bank .bank__note {
    text-align: center;
    margin-bottom: 0;
    margin-top: 30px;
}

@media screen and (max-width: 768px) {
    .va {
        flex-wrap: wrap;
        -webkit-flex-wrap: wrap;
    }

    .va__content {
        flex-basis: 100%;
        -webkit-flex-basis: 100%;
    }

    .qr__wrapper {
        width: fit-content;
        margin: 0 auto;
    }

    .guide .va .va__option {
        margin: 20px 0;
        width: 100%;
        font-size: 14px;
    }

    .va .va__option::before,
    .va .va__option::after {
        content: "";
        display: block;
        position: absolute;
        width: 40%;
        border-top: 0.5px solid #C2C2C2;
    }

    .va .va__option::before {
        left: 0;
    }

    .va .va__option::after {
        right: 0;
    }

    .guide>ul>li {
        padding: 16px 12px;
    }

    .guide__step>img {
        width: 32px;
    }

    .guide__step>img~div {
        padding-left: 42px;
    }

    .guide__step .va {
        padding-left: 0;
    }

    .guide .qr__area {
        width: 200px;
        height: 200px;
    }

    .guide .va p {
        font-size: 14px;
        text-align: center;
    }
}
</style>


