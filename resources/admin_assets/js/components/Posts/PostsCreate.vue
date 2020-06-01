<template>
    <v-form
        ref="form"
        v-model="valid"
        lazy-validation
    >
        <v-row justify="center">
            <v-col
                cols="12"
                md="12"
            >
                <v-card>
                    <v-list dense>
                        <v-list-item>
                            <v-list-item-content>عنوان</v-list-item-content>
                            <v-list-item-content class="align-end grow5">
                                <v-text-field
                                    label="عنوان"
                                    reverse
                                ></v-text-field>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-content>خلاصه</v-list-item-content>
                            <v-list-item-content class="align-end grow5">
                                <v-textarea
                                    label="خلاصه"
                                    reverse
                                ></v-textarea>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-content>تگ و دسته بندی</v-list-item-content>
                            <v-list-item-content class="align-end grow5">
                                <v-col md="6" sm="12">
                                    <v-autocomplete label='tag'></v-autocomplete>
                                </v-col>
                                <v-col md="6" sm="12">
                                    <v-autocomplete label='دسته بندی'></v-autocomplete>
                                </v-col>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-content>متن</v-list-item-content>
                            <v-list-item-content class="align-end grow5">
                                <my-editor></my-editor>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item class="my-5">
                            <v-btn color="primary" ripple block>ذخیره</v-btn>
                        </v-list-item>
                    </v-list>
                </v-card>
            </v-col>
        </v-row>
    </v-form>

</template>


<script>


    import MyEditor from "../Layouts/my-editor";

    export default {
        name: "PostsCreate",
        data() {
            return {
                valid: false
            }
        },
        components: {MyEditor},
        mounted() {

        }
    }
</script>

