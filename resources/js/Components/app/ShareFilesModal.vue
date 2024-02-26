<template>
    <Modal :show="props.modelValue" @show="onShow" max-width="sm">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">Share Files</h2>
            <div class="mt-6">
                <InputLabel
                    for="shareEmail"
                    value="Enter Email Address"
                    class="sr-only"
                />

                <TextInput
                    type="text"
                    ref="emailInput"
                    id="shareEmail"
                    v-model="form.email"
                    class="mt-1 block w-full"
                    :class="
                        form.errors.email
                            ? 'border-red-500 focus:border-red-500 focus:ring-red-500'
                            : ''
                    "
                    placeholder="Enter Email Address"
                    @keyup.enter="share"
                />

                <InputError :message="form.errors.email" class="mt-2" />
            </div>
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal">Cancel</SecondaryButton>
                <PrimaryButton
                    class="ml-3"
                    :class="{ 'opacity-25': form.processing }"
                    @click="share"
                    :disable="form.processing"
                >
                    Submit
                </PrimaryButton>
            </div>
        </div>
    </Modal>
</template>

<script setup>
import Modal from "@/Components/Modal.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import SecondaryButton from "../SecondaryButton.vue";
import PrimaryButton from "../PrimaryButton.vue";
import { nextTick, ref } from "vue";
import { showSuccessNotification } from "@/event-bus";

const emailInput = ref(null);
const page = usePage();

const form = useForm({
    email: null,
    all: false,
    ids: [],
    parent_id: null,
});

const emit = defineEmits(["update:modelValue"]);

const props = defineProps({
    modelValue: Boolean,
    allSelected: Boolean,
    selectedIds: Array,
});

function share() {
    //getting value of id
    form.parent_id = page.props.folder.data.id;

    if (props.allSelected) {
        form.all = true;
        form.ids = [];
    } else {
        form.ids = props.selectedIds;
    }

    const email = form.email;

    //used  to send a post request
    form.post(route("file.share"), {
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
            form.reset();
            //show success notification
            showSuccessNotification(
                `Selected files will be shared to "${email}" if the email exists in the system`
            );
        },
        onError: () => emailInput.value.focus(),
    });
}

function onShow() {
    nextTick(() => emailInput.value.focus());
}

function closeModal() {
    emit("update:modelValue");
    form.clearErrors();
    form.reset();
}
</script>
