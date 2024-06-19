<template>
    <div id="wrapper" class="wide">
        <!-- Header -->
        <Header :showHeaderSearchForm="true" :bigLogo="false" />
        <!-- /Header -->

        <!-- Content -->
        <slot />
        <!-- /Content -->

        <!-- Footer -->
        <Footer />
        <!-- /Footer -->
    </div>
</template>
<script>
import Footer from "@/Shared/Footer.vue";
import Header from "@/Shared/Header.vue";
export default {
    components: { Header, Footer },
};
</script>