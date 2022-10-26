<template>
    <aside class="admin-aside">
        <slot name="aside"></slot>
        <aside-bar
            :items="pagesList"
            @selected="selectItem"
        >

        </aside-bar>
    </aside>
    <div class="dashboard-panel">
        <page-form
            :page="selected"
            @pageAdded="handle"
            @clear="this.selected = null"
        >

        </page-form>
    </div>
</template>

<script>
import AsideBar from "./components/AsideBar";
import PageForm from "./components/PageForm";

export default {
    name: "AdminApp",
    props: {
        pages: {
            required: false,
        }
    },
    components: {
        AsideBar,
        PageForm,
    },
    data() {
        return {
            selected: null,
            pagesList: this.pages,
        }
    },
    methods: {
        handle(item) {
            // this.pagesList.push(item)
            console.log(item);
        },
        selectItem(item) {
            this.selected = item;
        }
    },
}
</script>

<style scoped>

</style>
