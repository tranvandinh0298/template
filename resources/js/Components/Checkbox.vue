<script setup>
defineProps({
    isActive: Boolean,
    isCircle: Boolean,
    showMark: Boolean
})
</script>

<template>
    <div class="checkbox" :class="{ active: isActive}">
        <div class="checkbox__label">
            <span v-show="showMark" class="checkbox__mark" :class="{circle: isCircle}"></span>
            <slot></slot>
        </div>
    </div>
</template>

<style scoped>
.checkbox {
    display: flex;
    min-height: 76px;
    overflow: hidden;
    flex: 1;
}

.checkbox__label {
    display: flex;
    width: 100%;
    justify-content: space-between;
    align-items: center;
    border-radius: 12px;
    border: 1px solid #EDEDED;
    padding: 10px 16px;
    cursor: pointer;
}

.checkbox.active .checkbox__label,
.checkbox__label:hover {
    border-color: var(--primary-color);
    background-color: #EAF1FB;
    text-decoration: none;
}

.checkbox__mark {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 24px;
    height: 24px;
    position: relative;
}

.checkbox__mark::before {
    content: "";
    display: block;
    width: 18px;
    height: 18px;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    position: absolute;
    background: transparent;
    border: 1px solid #b1b1b1;
    border-radius: 4px;
    z-index: 10;
}

.checkbox__mark.circle::before {
    width: 20px;
    height: 20px;
    border-radius: 50%;
}

.checkbox.active .checkbox__mark.circle::before {
    border-color: var(--primary-color);
    background-color: var(--primary-color);
}

.checkbox .checkbox__mark.circle::before {
    background-color: transparent;
    border-color: #b1b1b1;
}

.checkbox.active .checkbox__mark.circle::before {
    background-color: transparent;
}

.checkbox__mark::after {
    font-family: "Font Awesome 5 Pro", serif;
    content: "\f00c";
    font-size: 12px;
    display: none;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white;
    z-index: 11;
}

.checkbox__mark.circle::after {
    content: "";
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background-color: var(--primary-color);
}

.checkbox.active .checkbox__mark::after,
.checkbox.active .checkbox__mark::after {
    display: block;
}

@media screen and (max-width: 768px) {
    .checkbox__label {
        padding: 12px;
    }
}

</style>
