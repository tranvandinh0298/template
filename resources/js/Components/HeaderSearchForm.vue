<template>
    <form method="POST" id="header-search-form" action="#">
        <!-- @csrf -->
        <button type="submit">
            <i class="fas fa-search"></i>
        </button>
        <input type="text" name="contractNo" id="contractNo" value=""
            placeholder="Tìm kiếm Bill ID (Mã học sinh online)">
    </form>
</template>

<style scoped>
#header-search-form {
    position: relative;
    background: var(--primary-background-color);
    width: 70%;
    border-radius: 30px;
    padding: 10px 20px;
}

#header-search-form button {
    border: none;
    outline: none;
    background: transparent;
    margin-right: 6px;
}

#header-search-form button i {
    font-size: 16px;
    color: var(--primary-color);
    font-weight: 900;
}

#header-search-form input {
    width: 90%;
    color: var(--text-color);
    border: none;
    outline: none;
    background: transparent;
    border-bottom: 1px solid #E4E4E4;
    padding: 1px 2px;
}

#header-search-form input::placeholder {
    color: #C6C6C6;
}

@media screen and (max-width: 768px) {
    #header-search-form {
        width: 100%;
        margin-top: 15px;
        display: flex;
    }
}
</style>