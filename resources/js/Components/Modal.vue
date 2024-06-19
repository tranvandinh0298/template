<script setup>
defineProps({
    title: String,
    show: Boolean
});
</script>

<template>
    <Transition enter-from-class="opacity-0 scale-125" enter-to-class="opacity-100 scale-100"
                enter-active-class="transition duration-300" leave-active-class="transition duration-200"
                leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-125">
        <div v-if="show" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="fixed inset-0 bg-gray-800 opacity-75"></div>
            <div class="flex items-center justify-center min-h-screen px-4 py-8">
                <div class="bg-white rounded-lg shadow-xl overflow-hidden transform transition-all w-full md:w-2/5">
                    <div class="flex justify-between items-center px-4 py-2 border-b">
                        <h3 class="text-lg font-medium text-gray-900 mb-0">{{ title }}</h3>
                        <button type="button" @click="$emit('closeModal')" class="text-gray-400 hover:text-gray-500 focus:outline-none focus:text-gray-500">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="p-4 sm:p-6">
                        <slot></slot>
                    </div>
                </div>
            </div>
        </div>
    </Transition>
</template>

<style scoped>
.modal-mask {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, .6);
    display: grid;
    place-items: center;
}

.modal-container {
    background: white;
    padding: 1rem;
    width: 80vw;
    max-width: 500px;
    border-radius: 7px;
}

.modal-footer {
    border-top: 1px solid #ddd;
    margin-top: 1rem;
    padding-top: 0.5rem;
    font-size: .8rem;
}

.modal-footer button {
    background: #ddd;
    padding: .25rem .75rem;
    border-radius: 20px;
}

.modal-footer button:hover {
    background: #c8c8c8;
}
</style>
