<template>
    <div class="admin-aside__bar">
        <form action="#" class="form-main mb-1">
            <fieldset>
                <input type="text" placeholder="Пошук">
            </fieldset>
        </form>
        <ul class="aside-bar__list">
            <li v-for="item in pages">
                <p class="mb-1">
                    {{ item[2].title }}
                </p>
                <ul class="list">
                    <li v-for="info in item">
                        <span class="lang-item"
                              @click="select(info)"
                        >
                            {{ info.locale }}
                        </span>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "AsideBar",
    props: ['items'],
    data() {
        return {
            pages: null,
        }
    },
    methods: {
        groupBy(key) {
            return function group(array) {
                return array.reduce((acc, obj) => {
                    const property = obj[key];
                    acc[property] = acc[property] || [];
                    acc[property].push(obj);
                    return acc;
                }, {});
            };
        },
        sortItems() {
            let grouped = this.groupBy('group');
            this.pages = grouped(this.items);

        },
        select(item) {
            this.$emit('selected', item);
        }
    },
    mounted() {
        this.sortItems();
    }
}
</script>

<style lang="sass" scoped>
@import "resources/sass/admin/variables"

.aside-bar__list
    > li
        padding: .7rem 0
        border-bottom: 1px solid #dadada

.lang-item
    font: normal 700 .8em/1.2 $main-font
    cursor: pointer

</style>
