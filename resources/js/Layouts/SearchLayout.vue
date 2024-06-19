<template>
    <div id="wrapper">
        <div class="content-wrapper">
            <!-- Header -->
            <Header :showHeaderSearchForm="false" :bigLogo="true" />
            <!-- /Header -->

            <!-- Content -->
            <slot />
            <!-- /Content -->
        </div>

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