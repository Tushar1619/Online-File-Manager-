<template>
    <Modal :show="show" max-width="5xl">
        <div class="p-6">
            <div class="mb-4 mr-4 flex justify-end">
                <DangerButton @click="($event) => emit('close')">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-4 h-4"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 18 18 6M6 6l12 12"
                        />
                    </svg>
                </DangerButton>
            </div>
            <img v-if="showImage" :src="filepath" alt="Image" />
            <iframe
                v-if="showPdf"
                :src="filepath"
                frameborder="0"
                class="w-full aspect-[4/3]"
            ></iframe>
        </div>
    </Modal>
</template>

<script setup>
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";

const props = defineProps({
    show: Boolean,
    filepath: String,
    showImage: Boolean,
    showPdf: Boolean,
});

const emit = defineEmits(["close"]);
</script>
