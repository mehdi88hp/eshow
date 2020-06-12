<template>
    <v-dialog
        v-model="dialog"
        max-width="290"
    >
        <v-card>
            <v-card-title class="headline"></v-card-title>

            <v-card-text>آیا از پاک کردن این آیتم اطمینان داری ؟</v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    color="green darken-1"
                    text
                    @click="clicked(true)"
                >
                    بله
                </v-btn>
                <v-spacer></v-spacer>
                <v-btn
                    color="red darken-1"
                    text
                    @click="clicked(false)"
                >
                    خیر
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    export default {
        name: "ConfirmDelete",
        props: {
            value: Boolean
        },
        methods: {
            clicked(isDeleted) {
                this.dialog = false;
                if (isDeleted) {
                    this.$emit('deleteConfirmed', isDeleted)
                }
            }
        },
        computed: {
            dialog: {
                get() {
                    return this.value
                },
                set(value) {
                    this.$emit('input', value)
                }
            }
        }
    }
</script>
