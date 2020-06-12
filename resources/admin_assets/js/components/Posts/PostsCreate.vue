<template>
    <v-form
        ref="form"
        v-model="valid"
        @submit="submit"
    >
        <v-row justify="center">
            <v-col
                cols="12"
                md="8"
                sm="10"
            >
                <v-card class="pa-5">
                    <v-text-field
                        label="عنوان"
                        v-model="form.title"
                        reverse
                        :rules="titleRules"
                    ></v-text-field>
                    <v-textarea
                        :rules="excerptRule"
                        counter
                        v-model="form.excerpt"
                        label="خلاصه"
                        reverse
                        auto-grow
                        rows="1"
                    ></v-textarea>
                    <v-row>
                        <v-col md="6" sm="12">
                            <v-combobox
                                v-model="form.tag"
                                :items="tagItems"
                                :rules="tagRules"
                                @change="checkTag"
                                chips
                                deletable-chips
                                multiple
                                label='tag'></v-combobox>
                        </v-col>
                        <v-col md="6" sm="12">
                            <v-autocomplete
                                v-model="form.categories"
                                :items="catItems"
                                :rules="categoryRules"
                                :loading="isLoading"
                                :search-input.sync="searchCat"
                                chips
                                deletable-chips
                                label='دسته بندی'></v-autocomplete>
                        </v-col>
                    </v-row>
                    <v-divider></v-divider>
                    <v-col sm="12" class="ma-5">
                        <v-label class="ma-5"><h3>متن</h3></v-label>
                    </v-col>
                    <my-editor v-model="form.content"></my-editor>
                    <!--                    <label v-if="contentError">{{contentError}}</label>-->

                    <v-btn color="primary" ripple block class="mt-5" :disabled="!valid" @click="submit">ذخیره</v-btn>

                </v-card>
            </v-col>
        </v-row>
    </v-form>

</template>


<script>


    import MyEditor from "../Layouts/my-editor";

    export default {
        name: "PostsCreate",
        components: {MyEditor},
        data() {
            return {
                isLoading: false,
                searchCat: null,
                valid: false,
                form: {
                    content: '',
                    categories: [],
                    tag: [],
                    title: '',
                    excerpt: '',
                },
                content: '',
                categories: '',
                tag: [],
                catItems: [''],
                categories: [],
                title: '',
                excerpt: '',
                tagItems: [],
                titleRules: [
                    v => !!v || 'عنوان الزامی است',
                    v => v.length >= 3 || 'حداقل 6 کاراکتر الزامی است',
                ],
                excerptRule: [
                    v => !!v || 'عنوان الزامی است',
                    v => v.length >= 30 || 'حداقل 30 کاراکتر الزامی است',
                ],
                tagRules: [
                    v => {
                        return !!v.length || 'انتخاب تگ الزامی است'
                    },
                ],
                categoryRules: [
                    v => !!this.catItems.length || 'انتخاب دسته بندی الزامی است',
                ]
            }
        },
        computed: {
            contentError() {
                return this.form.content.length < 150 ? 'حداقل 150 کاراکتر الزامی است' : false;
            }
        },
        methods: {
            checkTag() {
                console.log(23424, this.tags, this.content, 888)
            },
            submit() {
                this.formLoading = true;
                axios.post('/admin/contents/posts/store', this.form).then(r => {
                    this.$router.push({name: 'posts.index'});
                })
            }
        },
        watch: {
            searchCat(val) {
                if (this.isLoading) return
                this.isLoading = true
                // Lazily load input items
                axios.post('/admin/contents/categories/search', {val})
                    .then(res => {
                        this.count = res.data.length
                        this.catItems = res.data.data
                    })
                    .catch(err => {
                        console.log(err)
                    })
                    .finally(() => (this.isLoading = false))
            },
            mounted() {

            }
        },

        mounted() {

        }
    }
</script>

