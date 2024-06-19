<script setup>
import { reactive, ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import Swal from 'sweetalert2';

const form = reactive({
    contractNo: '',
});

const errors = ref({});

const validateForm = () => {
    const newErrors = {};

    form.contractNo = form.contractNo.trim();
    if (!form.contractNo) {
        newErrors.name = 'Mã khách hàng/ mã học sinh (contractNo) là bắt buộc';
    }

    errors.value = newErrors;

    return Object.keys(newErrors).length === 0;
};

const errorsToString = () => {
    return Object.values(errors.value).join(", ");
}

const handleSubmit = () => {
    if (!validateForm()) {
        console.log("validate fail", form);
        Swal.fire({
            title: 'Error!',
            text: errorsToString(),
            icon: 'error',
            confirmButtonText: 'OK'
        })
        return;
    }

    Inertia.post('/search', form, {
        onError: (errorBag) => {
            console.log("onError");
            errors.value = errorBag;

            Swal.fire({
                title: 'Lỗi!',
                text: errorsToString(),
                icon: 'error',
                confirmButtonText: 'OK'
            });
        },
        onFinish: () => {
            console.log('Request finished');
        },
        onStart: () => {
            console.log('Request started');
        },
        onProgress: (progress) => {
            console.log('Progress:', progress);
        }
    });
};
</script>

<template>
    <form @submit.prevent="handleSubmit" id="search-form">
        <h1 class="form__title">Cổng thu phí <span>học đường</span></h1>
        <p class="mb-2">Vui lòng nhập Mã học sinh để tra cứu thông tin thanh toán học phí!</p>
        <div class="form__group">
            <i class="fas fa-user-circle"></i>
            <input type="text" class="form__input" id="contractNo" v-model="form.contractNo"
                placeholder="Bill ID (Mã học sinh online)">
            <button type="submit" class="form__btn">
                <span>Tra cứu</span>
            </button>
        </div>
    </form>
</template>

<style scoped>
#search-form {
    display: block;
    height: 100%;
    width: 32%;
    border-radius: 8px;
    position: relative;
    color: white;
    z-index: 2;
}

#search-form .form__title {
    color: white;
    font-size: 45px;
    font-weight: 600;
    margin-bottom: 16px;
    text-transform: uppercase;
}

#search-form .form__group {
    position: relative;
    width: 100%;
    outline: none;
    flex: 1;
    -webkit-flex: 1;
    -moz-flex: 1;
    -ms-flex: 1;
    font-size: 16px;
    border-radius: 30px;
    border: 1px solid #E4E4E4;
    background: #FFF;
    padding: 16px 130px 16px 70px;
    height: auto;
    display: flex;
}

#search-form input {
    outline: none;
    border: none;
    flex: 1;
    border-bottom: 1px solid #E4E4E4;
    padding: 1px 2px;
    color: var(--text-color);
}

#search-form .form__btn {
    right: 4px;
    background-color: var(--primary-color);
    color: white;
    border-radius: 30px;
    padding: 14px 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    outline: none;
    border: none;
}

#search-form i {
    left: 25px;
    color: #C4C4C4;
    margin-right: 12px;
    font-size: 24px;
}

#search-form .form__btn,
#search-form i {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
}

#search-form label {
    margin-bottom: 16px;
    font-weight: 400;
}

#search-form input::placeholder {
    color: var(--text-label-color);
    font-weight: 400;
}

@media screen and (max-width: 768px) {
    .form__title {
        text-align: center;
        font-size: 42px;
        margin: 20px 0 26px;
    }

    #search-form {
        padding-top: 0;
        width: 100%;
        margin-bottom: 20px;
    }

    #search-form .form-group {
        margin-bottom: 20px;
    }

    #search-form .form__group {
        padding: 10px 100px 10px 50px;
    }

    #search-form input {
        padding: 8px 10px;
    }

    #search-form i {
        left: 16px;
    }

    .button {
        padding: 15px 20px;
        min-width: 100px;
    }

    #search-form .form__btn {
        padding: 10px 22px;
    }

    .logo__image {
        max-width: 100%;
    }
}
</style>
