<script>
import SectionCard from "@/Components/SectionCard";

export default {
    components: {
        SectionCard
    }
}
</script>

<template>
    <section class="col col-md-3 col-12">
        <SectionCard>
            <template #header>
                <div class="flex items-center">
                    <img src="@/../images/common/icon_user_with_background_2.png" alt="">
                    <a href="javascript:void(0)"> Thông tin học sinh </a>
                </div>
            </template>
            <template #body>
                <div class="customer__list">
                    <ul>
                        <li>
                            <input type="checkbox" id="0007000010" name="customer_id" value="0007000010" checked>
                            <label for="0007000010" class="customer__label">
                                <span class="checkbox"></span>
                                <a href="#collapse-0007000010">
                                    <span class="customer__info">Nguyễn Văn A</span>
                                </a>
                            </label>
                            <div id="collapse-0007000010" class="customer__info">
                                <p>Bill ID: 0007000010</p>
                                <p>Lớp: lá 1 tiểu học Epay</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </template>
        </SectionCard>
    </section>
</template>

<style>
.customer__list {}

.customer__list li+li {
    border-top: 1px solid #EDEDED;
    margin-top: 10px;
}

.customer__list input {
    display: none;
}

.customer__label {
    display: flex;
    align-items: center;
    margin: 0;
    padding: 14px 0;
}

.customer__label button,
.customer__label a {
    display: flex;
    align-items: center;
    justify-content: center;
    -webkit-justify-content: center;
    -moz-justify-content: center;
    color: var(--text-color);
}

.customer__label .checkbox {
    display: flex;
    justify-content: center;
    -webkit-justify-content: center;
    -moz-justify-content: center;
    align-items: center;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 1px solid var(--text-color);
    margin-right: 12px;
    margin-left: 12px;
}

.customer__label .checkbox::before {
    content: "";
    width: 12px;
    height: 12px;
    display: block;
    background-color: none;
    border-radius: 50%;
}

.customer__list input:is(:checked)~.customer__label .checkbox {
    border-color: var(--primary-color);
}

.customer__list input:is(:checked)~.customer__label .checkbox::before {
    background-color: var(--primary-color);
}

.customer__info {
    font-weight: 600;
}

.customer__info p {
    margin: 0;
    padding-left: 44px;
    font-weight: 400;
}

.customer__info p+p {
    margin-top: 10px;
}
</style>
