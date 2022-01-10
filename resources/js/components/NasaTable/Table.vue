<template>
    <div class="container">
        <div class="row">
            <div class="col">
                <span class="form-label fw-bolder">Show</span>
                <select v-model="currentEntries" class="form-select entries" @change="getEventsPerPage">
                    <option v-for="num in showEntries" :key="num" :value="num">{{num}}</option>
                </select>
                <span class="form-label">entries</span>
            </div>
            <div class="col">
                <span class="form-label fw-bolder">Category</span>
                <select v-model="currentCategory" class="form-select category" @change="showByCategory">
                    <option value="0">All</option>
                    <option v-for="c in categories" :key="c.id" :value="c.id">{{c.title}}</option>
                </select>
            </div>
        </div>

        <TableBase v-bind:entries="this.filteredEntries" v-bind:categories="this.categories"/>

        <div class="table-footer">
            <div class="info">
                Show {{showInfo.from}} to {{ showInfo.to }} of {{ showInfo.of }} entries
            </div>
            <div>
                <ul class="pagination">
                    <li :class="['page-item', {'disabled': currentPage === 1}]">
                        <a href="#" class="page-link" @click.prevent="paginateEvent(1)">First</a>
                    </li>
                    <li v-for="pagi in showPagination"
                        :class="['page-item', {'disabled': pagi === '...', 'active': pagi === currentPage}]">
                        <a href="#" class="page-link" @click.prevent="paginateEvent(pagi)">{{ pagi }}</a>
                    </li>
                    <li :class="['page-item', {'disabled': currentPage === allPages}]">
                        <a href="#" class="page-link" @click.prevent="paginateEvent(allPages)">Last</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
import {$array} from 'alga-js';
import TableBase from "./TableBase";

export default {
    name: "Table",
    components: {
        TableBase
    },
    data(){
        return {
            title: "Nasa events",
            entries: [],
            categories: [],
            showEntries: [5, 10, 20],
            currentEntries: 5,
            currentCategory: 0,
            filteredEntries: [],
            currentPage: 1,
            allPages: 1,
            filteredEvents: []
        }
    },

    computed:{
        showInfo(){
            return $array.show(this.filteredEvents, this.currentPage, this.currentEntries);
        },
        showPagination(){
            return $array.pagination(this.allPages, this.currentPage, 2);
        }
    },

    mounted() {
        this.getEvents();
        this.getCategories();
    },

    methods:{
        getEvents(){
            axios.get('/events')
            .then(res => {
                this.entries = res.data;
                this.filteredEvents = this.entries;
                this.getEventsPerPage();
                this.numberOfAllPages();
            });
        },
        getCategories(){
            axios.get('/categories')
                .then(res => {
                    this.categories = res.data;
                });
        },
        numberOfAllPages(){
            this.allPages = $array.pages(this.filteredEvents, this.currentEntries);
        },
        getEventsPerPage(){
            this.numberOfAllPages();
            if(this.currentPage > this.allPages){
                this.currentPage = this.allPages;
            }
            this.filteredEntries = $array.paginate(this.filteredEvents, this.currentPage, this.currentEntries);
        },
        paginateEvent(page){
            this.currentPage = page;
            this.getEventsPerPage();
        },
        showByCategory(){
            if (this.currentCategory === '0'){
                this.filteredEvents = this.entries;
            } else {
                this.filteredEvents = this.entries.filter(event => {
                    return event.category_id === this.currentCategory;
                });
            }
            this.getEventsPerPage();
        }
    }
}
</script>

<style scoped>
    .entries{
        width: 20%;
        margin: 0 10px;
    }
    .category{
        margin-left: 10px;
        width: 70%;
    }
    .entries, .category{
        display: inline-block;
    }
    .table-footer{
        display: flex;
        justify-content: space-between;
    }
    .page-item.active .page-link{
        background-color: #183148;
        border-color: #183148;
    }
    .page-link{
        color: #183148;
    }
</style>
