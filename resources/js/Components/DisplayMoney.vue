<script setup>
  defineProps({
    amount: Number
  })
</script>

<template>
    <span>{{amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}} đ</span>
</template>
