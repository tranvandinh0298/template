<template>
    <footer class="footer">
        <div class="footer__container">
            <div class="footer__info company">
                <div class="footer__column">
                    <div class="footer__header">
                        <img src="@/../images/common/logo_vnptepay.png" alt="">
                    </div>
                    <div class="footer__address">
                        <span class="company__info">
                            <span class="font-weight-bold">Trụ sở Hà Nội:</span> Tầng 14, tòa nhà Handico, khu đô thị
                            mới
                            Mễ Trì Hạ, đường Phạm Hùng, quận Nam Từ Liêm, Hà Nội
                        </span>
                        <span class="company__info">
                            <span class="font-weight-bold">Điện thoại: </span> +8428-35265969
                            <span class="font-weight-bold">Fax: </span> +8428-38443786
                        </span>
                    </div>
                    <div class="footer__address">
                        <span class="company__info">
                            <span class="font-weight-bold">Chi nhánh HCM:</span> Phòng 702, 111D Lý Chính Thắng, Phường
                            7,
                            Quận 3, Hồ Chí Minh
                        </span>
                        <span class="company__info">
                            <span class="font-weight-bold">Điện thoại: </span> +8428-35265969
                            <span class="font-weight-bold">Fax: </span> +8428-38443786
                        </span>
                    </div>
                </div>
            </div>
            <div class="footer__info">
                <div class="footer__column">
                    <div class="footer__header">
                        <p class="text-uppercase">Điều khoản</p>
                    </div>
                    <a href="" target="_blank" rel="noopener noreferrer">Chất lượng dịch vụ</a>
                    <a href="" target="_blank" rel="noopener noreferrer">Quy trình giải quyết khiếu nại</a>
                    <a href="" target="_blank" rel="noopener noreferrer">Quy định và hình thức thanh toán</a>
                    <a href="" target="_blank" rel="noopener noreferrer">Điều khoản và chính sách sử dụng</a>
                    <a href="" target="_blank" rel="noopener noreferrer">Chính sách hoàn tiền</a>
                </div>
            </div>
            <div class="footer__info">
                <div class="footer__column">
                    <div class="footer__header">
                        <p class="text-uppercase">Liên hệ với chúng tôi</p>
                    </div>
                    <div class="footer__social">
                        <a href="#">
                            <img id="social_fb" src="@/../images/common/social_logo_fb.png" alt="">
                        </a>
                        <a href="#">
                            <img id="social_linkedin" src="@/../images/common/social_logo_linkedin.png" alt="">
                        </a>
                        <a href="#">
                            <img id="social_gmail" src="@/../images/common/social_logo_gmail.png" alt="">
                        </a>
                    </div>
                </div>
            </div>
            <div class="footer__info">
                <div class="footer__column">
                    <div class="footer__header">
                        <p class="text-uppercase">Chính sách bảo mật</p>
                    </div>
                    <a href="" target="_blank" rel="noopener noreferrer">Chính sách bảo mật thông tin khách hàng</a>
                    <div class="footer__cert">
                        <img id="cert_secure" src="@/../images/common/cert_secure.png" alt="">
                        <img id="cert_pci_dss" src="@/../images/common/cert_pci_dss.png" alt="">
                        <img id="cert_issq" src="@/../images/common/cert_issq.png" alt="">
                    </div>
                </div>
            </div>
        </div>
        <p class="footer__copycat">
            © 2023 VNPTEPAY - All Rights Reserved.
        </p>
    </footer>
</template>

<script>

</script>

<style scoped>
.footer {
    border-top: 1px solid var(--primary-label-color);
    background: #FFF;
    padding-top: 20px;
    color: var(--text-color);
    min-height: 185px;
}

#wrapper.auth .footer {
    padding: 26px 20px 12px 20px;
}

.footer__container {
    display: flex;
    position: relative;
    justify-content: space-between;
    -webkit-justify-content: space-between;
    -moz-justify-content: space-between;
    margin: 0 auto;
}

#wrapper.auth .footer__container {
    width: 80%;
}

.footer__column+.footer__column {
    margin-left: 100px;
}

.footer__info {
    display: flex;
}

.footer__info span {
    font-size: 12px;
}

.footer__info.company {
    width: 350px;
}

.footer__info.company .footer__column img {
    height: 100%;
    width: auto;
    object-fit: contain;
}

.company__info {
    display: block;
}

.footer__address {
    line-height: 1.6;
}

.footer__address+.footer__address {
    margin-top: 20px;
}

.footer__header {
    display: flex;
    align-items: flex-end;
    height: 56px;
    margin-bottom: 20px;
}

.footer__info a {
    display: block;
    color: var(--text-color);
    font-size: 12px;
    font-weight: 400;
}

.footer__info a+a {
    margin-top: 5px;
}

.footer__info a:hover {
    text-decoration: none;
    color: var(--primary-color);
}

.footer__info p {
    margin-top: 0px;
    margin-bottom: 0px;
}

.footer__info p:first-child {
    font-weight: 600;
}

.footer__cert {
    display: flex;
    width: 100%;
    margin-top: 15px;
    justify-content: space-between;
    -webkit-justify-content: space-between;
    -moz-justify-content: space-between;
    align-items: center;
}

.footer__cert img {
    max-width: 114px;
    height: auto;
    object-fit: contain;
}

.footer__cert img+img {
    margin-left: 20px;
}

.footer__copycat {
    margin-bottom: 0;
    width: 100%;
    display: flex;
    justify-content: center;
    padding: 12px 0;
    border-top: 1px solid #BBB;
    margin-top: 20px;
}

.footer__social {
    display: flex;
    align-items: center;
}

.footer__social a+a {
    margin-top: 0;
    margin-left: 14px;
}

.footer__social img {
    max-height: 28px;
    width: auto;
    object-fit: contain;
}

#social_gmail {
    max-height: 34px;
}


@media screen and (max-width: 768px) {
    .footer {
        padding: 20px 20px 0 20px;
    }

    .footer__container {
        width: 100% !important;
    }

    .footer__container,
    .footer__info {
        flex-direction: column;
        -webkit-flex-direction: column;
        -moz-flex-direction: column;
    }

    .footer__header {
        height: 40px;
        margin-bottom: 10px;
    }

    .footer__info+.footer__info {
        margin-top: 20px;
    }

    .footer__column+.footer__column {
        margin-left: 0;
        margin-top: 20px;
    }

    .footer__info.company {
        width: 100%;
    }

}
</style>