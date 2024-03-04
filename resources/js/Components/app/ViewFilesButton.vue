<template>
    <PrimaryButton @click="view"> View </PrimaryButton>
    <ViewDialog
        :show="showViewDialog"
        :filepath="filepath"
        @close="close"
        :show-image="showImage"
        :show-pdf="showPdf"
    />
</template>

<script setup>
import { usePage } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { httpGet } from "@/Helper/http-helper.js";
import { ref } from "vue";
import ViewDialog from "../ViewDialog.vue";

const page = usePage();

const filepath = ref("");
const showViewDialog = ref(false);
const showImage = ref(false);
const showPdf = ref(false);

const props = defineProps({
    file: Object,
});

function view() {
    httpGet(route("file.show", { filepath: props.file.storage_path }))
        .then((res) => {
            console.log(res);
            filepath.value = res.path;
            showViewDialog.value = true;
            if (props.file.mime == "image/png") {
                showImage.value = true;
            }
            if (props.file.mime == "application/pdf") {
                showPdf.value = true;
            }
        })
        .catch((error) => {
            console.log(error);
        });
    // console.log(filepath);
    // console.log("view invoked");
}

function close() {
    showViewDialog.value = false;
}
</script>
