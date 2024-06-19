<script setup>
import HeaderSearchForm from "@/Components/HeaderSearchForm";
defineProps({
    showHeaderSearchForm: Boolean,
    bigLogo: Boolean,
});
</script>

<template>
    <header class="header">
        <div class="header__container">
            <nav class="header__nav row">
                <div class="col col-md-3 col-6">
                    <a href="/" class="logo__image">
                        <img v-if="bigLogo" src="@/../images/common/logo_school_portal.png" alt="">
                        <img v-else="bigLogo" src="@/../images/common/logo_vnptepay.png" alt="">
                    </a>
                </div>
                <div v-show="showHeaderSearchForm"
                    class="col col-md-6 col-12">
                    <HeaderSearchForm />
                </div>
                <div class="col col-md-3 col-6">
                    <div class="flex justify-end">
                        <a href="tel:+4733378901" class="button">
                            <i class="fas fa-phone-volume"></i>
                            <span>1900 6470</span>
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </header>
</template>

<style scoped>
.header {
    display: flex;
    align-self: center;
    width: 100%;
    padding: 14px 0;
    height: 90px;
}

.content .header {
    padding: 0;
}

.header__nav {
    display: flex;
    height: 100%;
    align-items: center;
    width: 100%;
    justify-content: space-between;
}

.content .header__nav {
    padding-bottom: 70px;
}

.logo {
    flex: 1;
    -webkit-flex: 1;
    -moz-flex: 1;
    -ms-flex: 1;
    display: flex;
    width: 100%;
    justify-content: space-between;
    -webkit-justify-content: space-between;
    -moz-justify-content: space-between;
    align-items: center;
}

.logo__image {
    display: block;
    width: auto;
    height: auto;
    max-width: 40%;
    max-height: 100%;
}

.logo__image img {
    max-width: 175px;
    max-height: 100%;
    width: 100%;
    height: auto;
    object-fit: contain;
}

.content-wrapper .logo__image img {
    max-width: 100px;
}

.language {
    display: flex;
    width: auto;
    margin-left: 46px;
    padding: 2px 0;
    position: relative;
}

.language::before {
    content: "";
    display: block;
    width: 0;
    height: 100%;
    border-left: 1px solid #D7D7D7;
    position: absolute;
    top: 0;
    left: -23px;
}

.language__button {
    display: flex;
    align-items: center;
    justify-content: center;
    -webkit-justify-content: center;
    -moz-justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 32px;
    background: var(--primary-background-color);
}

.language__button+.language__button {
    margin-left: 8px;
}

.language__button:hover {
    background: #f3f0f0;
}

.language__button img {
    max-width: 60%;
    height: auto;
    object-fit: contain;
    transition: all 0.2s linear;
}

.language__button:hover img {
    transform: scale(1.1);
}

.header__nav .button {
    width: 128px;
    padding: 10px 10px 10px 14px;
    border: none;
    outline: none;
    border-radius: 8px;
    box-shadow: 0px 4px 8px 0px rgba(3, 165, 227, 0.25);
    -moz-box-shadow: 0px 4px 8px 0px rgba(3, 165, 227, 0.25);
    -webkit-box-shadow: 0px 4px 8px 0px rgba(3, 165, 227, 0.25);
    background: var(--primary-color);
    color: #fff;
    font-size: 14px;
    line-height: 1;
    font-weight: 400;
    display: flex;
    justify-content: space-evenly;
}

.header__nav .logo .button i {
    margin-right: 8px;
}

@media screen and (max-width: 768px) {
    .header__nav div:nth-child(1) {
        order: 1;
    }

    .header__nav div:nth-child(2) {
        order: 3;
    }

    .header__nav div:nth-child(3) {
        order: 2;
    }

    .logo__image {
        max-width: unset;
    }
}

@media screen and (max-width: 768px) {
    .header {
        padding: 16px 12px;
        height: auto;
    }
}

</style>
