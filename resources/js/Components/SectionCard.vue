<script>
</script>

<template>
    <div class="card primary">
        <div class="card-header">
            <slot name="header"></slot>
        </div>
        <div class="card-body">
            <slot name="body" />
        </div>
    </div>
</template>

<style>
.main-content .card {
    border-radius: 16px;
    background: #FFF;
    overflow: hidden;
    border-color: #fff;
}

.main-content .card.payment_info {
    height: 100%;
}

.main-content .card+.card {
    margin-top: 20px;
}

.main-content .card-header img+a {
    margin-left: 16px;
}

.main-content .card-header {
    padding: 14px 24px;
    background: #fff;
    border-bottom-color: #EDEDED;
    display: flex;
    align-items: center;
    justify-content: space-between;
    -webkit-justify-content: space-between;
}

.main-content .card-header a {
    color: var(--text-color);
    font-weight: 600;
    font-size: 20px;
}

.card.primary .card-header a {
    color: var(--primary-color);
}

.main-content .card-header a:hover {
    text-decoration: none;
}

.payment__title {
    display: block;
    flex-basis: 100%;
    font-size: 14px;
    color: var(--text-color);
    margin: 0px 12px 12px 12px;
    background: #F8F8F8;
    font-weight: 600;
}

@media screen and (max-width: 768px) {
    .main-content .card {
        margin-bottom: 20px;
    }
}
</style>
