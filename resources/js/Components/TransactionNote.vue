<template>
    <div class="note">
        <img src="@/../images/common/icon_warning_with_background.png"
             alt="">
        <p class="note__title">Lưu ý:</p>
        <ul class="note__list">
            <li class="note__item">
                <p>Quý khách hàng vui lòng thanh toán chính xác thông tin Tài khoản, tên
                    chủ Tài khoản, Số tiền như hướng dẫn trên.</p>
            </li>
            <li class="note__item">
                <p>Trường hợp Quý khách hàng chuyển tiền không đúng thông
                    tin trên, Ngân hàng sẽ từ chối giao dịch và hoàn trả lại
                    tiền cho quý khách theo quy định của Ngân hàng.</p>
            </li>
            <li class="note__item">
                <p>Số tài khoản/ mã QR này có hiệu lực trong vòng 3 ngày và
                    chỉ được sử dụng 1 lần duy nhất cho kỳ thanh toán này.
                    Sau thời hạn 3 ngày, số Tài khoản/ mã QR này sẽ tự động
                    bị hủy.</p>
            </li>
        </ul>
    </div>
</template>

<style scoped>

.note {
    display: block;
    font-size: 14px;
    line-height: 18px;
    background: #FFF4F4;
    border-radius: 16px;
    width: auto;
    min-height: 80px;
    overflow: visible;
    font-weight: 400;
    z-index: 1;
    transition: all 0.3s linear;
    position: relative;
    padding: 20px 22px;
    margin-top: 10px;
}

.note img {
    position: absolute;
    top: 20px;
    left: 22px;
    max-width: 50px;
}

.note__title {
    font-size: 16px;
    font-weight: 600;
    padding-left: 70px;
    margin-bottom: 12px;
}

.note__list {
    display: block;
    max-width: 100%;
    height: auto;
    margin-top: 6px;
    padding-left: 70px;
}

.note__list p {
    margin-bottom: 0;
}

.note__item {
    display: flex;
    width: 100%;
    padding-left: 20px;
    position: relative;
}

.note__item+.note__item {
    margin-top: 10px;
}

.note__item::before {
    font-family: "Font Awesome 5 Free",serif;
    content: "\f111";
    font-weight: 900;
    font-size: 5px;
    line-height: 5px;
    position: absolute;
    top: 5px;
    left: 5px;
    color: var(--text-color);
}

.note__item a {
    margin-left: 5px;
    color: #3B8EFF;
    text-decoration: underline;
}

@media screen and (max-width: 768px) {
    .note {
        padding-left: 12px;
        padding-right: 12px;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        -webkit-flex-wrap: wrap;
    }

    .note__title {
        flex: 1;
        -webkit-flex: 1;
        -moz-flex: 1;
        -ms-flex: 1;
        padding-left: 10px;
        margin-bottom: 0;
    }

    .note img {
        position: unset;
        height: auto;
    }

    .note__list {
        margin-top: 10px;
        padding-left: 6px;
    }
}

</style>
