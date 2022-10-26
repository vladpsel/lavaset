<template>
    <div class="flex f-between v-center mb-1">
        <h1 class="title-main item">Cторінка</h1>
        <div class="btn-group item">
            <button type="button" class="btn btn-main neutral"
                    @click="clear"
            >
                Очистити
            </button>
            <button type="button" class="btn btn-main primary"
                    @click="createPage"
                    v-if="this.page === null"
            >
                Створити
            </button>
            <button type="button" class="btn btn-main primary"
                    @click="updatePage"
                    v-else
            >
                Оновити
            </button>
        </div>
    </div>
    <form
        class="form-main flex"
        @submit.prevent
    >
        <div class="flex">
            <fieldset class="two-of-four">
                <label class="label">Назва</label>
                <input type="text" v-model="singlePage.title"
                       @input="translit"
                >
            </fieldset>
            <fieldset class="two-of-four">
                <label class="label">Аліас</label>
                <input type="text" v-model="singlePage.alias">
            </fieldset>
            <p class="notice mb-1 full">
                Аліас - це url сторінки (унікальний ID). Наприклад: site.com/<span class="bold">alias</span>.
                Аліас необхідно заповнювати латинськими літерами, низьким регістром, замість пробілу використовувати "-"
            </p>
        </div>
        <fieldset class="two-of-four">
            <label class="label">Опис</label>
            <textarea cols="30" rows="10" v-model="singlePage.description"></textarea>
        </fieldset>
        <fieldset class="two-of-four">
            <label class="label">Ключові слова</label>
            <textarea cols="30" rows="10" v-model="singlePage.keywords"></textarea>
        </fieldset>

    </form>
</template>

<script>
import CyrillicToTranslit from 'cyrillic-to-translit-js';
import axios from 'axios';

export default {
    name: "PageForm",
    props: ['page'],
    emits: ['pageAdded', 'clear'],
    data() {
        return {
            placeholder: {
                title: '',
                isEditable: true,
                description: '',
                keywords: '',
                alias: '',
            },
        }
    },
    methods: {
        translit() {
            // if (!this.singlePage.isEditable) {
            //     return;
            // }
            // console.log('qw');
            let translit = new CyrillicToTranslit(
                {
                    preset: 'uk',
                }
            );
            this.singlePage.alias = translit.transform(this.singlePage.title, '-').toLowerCase();
        },
        createPage() {
            let obj = this.singlePage;
            let request = axios.post('/admin/pages/create', {
                data: obj,
            }).then((response) => {
                if (response.status === 200) {
                    this.$emit('pageAdded', response.data);
                    this.clear();
                }
            })
        },
        updatePage() {

        },
        clear() {
            this.placeholder = {
                title: '',
                isEditable: true,
                description: '',
                keywords: '',
                alias: '',
            }
            this.$emit('clear');
        }
    },
    computed: {
        singlePage() {
            if (this.page === null) {
                return this.placeholder;
            } else {
                return this.page;
            }
        }
    }
}
</script>

<style scoped>

</style>
