<script>
import SearchLayout from "@/Layouts/SearchLayout";
import SearchForm from "@/Components/SearchForm";
export default {
    components: {
        SearchForm,
    },
    layout: SearchLayout
};
</script>

<template>
    <div class="content">
        <div class="content__container">
            <div class="main-content">
                <SearchForm />
            </div>
        </div>
        <img class="content__banner" src="@/../images/banners/banner_tuition.png" alt="">
    </div>
</template>

<style>

</style>
