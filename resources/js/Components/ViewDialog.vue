<template>
    <Modal :show="show" max-width="5xl">
        <div class="p-6 relative">
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
            <div>
                <img v-if="showImage" :src="filepath" alt="Image" />
                <iframe
                    v-if="showPdf"
                    :src="filepath"
                    frameborder="0"
                    class="w-full aspect-[4/3]"
                ></iframe>
                <object
                    v-if="showText"
                    :data="filepath"
                    class="w-full"
                ></object>
                <video v-if="showVideo" controls autoplay class="w-full">
                    <source :src="filepath" type="video/mp4" />
                    Error Playing Video
                </video>
                <audio v-if="showAudio" controls autoplay class="w-full">
                    <source :src="filepath" type="audio/mpeg" />
                    Error playing audio
                </audio>
            </div>
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
    showText: Boolean,
    showVideo: Boolean,
    showAudio: Boolean,
});

const emit = defineEmits(["close"]);
</script>

<style scoped>
video {
    border-radius: 30px;
}
audio::-webkit-media-controls-panel {
    background-color: #cae5ff;
}
audio::-webkit-media-controls-mute-button {
    background-color: #83c0d5;
    border-radius: 50%;
    margin-right: 7px;
}
audio::-webkit-media-controls-play-button:hover {
    background-color: #75a5b5;
    border-radius: 50%;
}
audio::-webkit-media-controls-play-button {
    background-color: #83c0d5;
    border-radius: 50%;
}
audio::-webkit-media-controls-volume-slider {
    background-color: #83c0d5;
    border-radius: 25px;
    padding-left: 8px;
    padding-right: 8px;
    margin-right: 5px;
}
</style>
