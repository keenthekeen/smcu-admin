<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                โครงการ
            </h2>
        </template>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <search-input class="mb-4" v-model="searchKeyword" :status="searchMessage" />
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-2 py-2 md:px-4 md:py-3 text-left text-xs font-medium text-gray-500 tracking-wider">
                                เลขที่
                            </th>
                            <th scope="col" class="px-2 py-2 md:px-4 md:py-3 text-left text-xs font-medium text-gray-500 tracking-wider">
                                ชื่อ
                            </th>
                            <th scope="col" class="px-2 py-2 md:px-4 md:py-3 text-left text-xs font-medium text-gray-500 tracking-wider">
                                สังกัด
                            </th>
                            <th scope="col" class="px-2 py-2 md:px-4 md:py-3 text-left text-xs font-medium text-gray-500 tracking-wider">
                                วันที่จัด
                            </th>
                            <th scope="col" class="relative px-2 py-2 md:px-4 md:py-3 hidden md:table-cell">
                                <span class="sr-only">Edit</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="item in list.data" :key="item.id">
                            <td class="px-2 py-2 md:px-4 md:py-3">
                                    {{ item.year }}-{{ item.number }}
                            </td>
                            <td class="px-2 py-2 md:px-4 md:py-3">
                                <inertia-link :href="route('projects.show', {project: item.id})">
                                    {{ item.name }}
                                </inertia-link>
                            </td>
                            <td class="px-2 py-2 md:px-4 md:py-3 text-sm">
                                <span v-if="item.department_id === 33" class="text-gray-400">-</span>
                                <template v-else>{{ item.department.name }}</template>
                            </td>
                            <td class="px-2 py-2 md:px-4 md:py-3 text-gray-500 text-xs">
                                {{ item.period_start }}
                                <span v-if="item.period_start !== item.period_end">- {{ item.period_end }}</span>
                            </td>
                            <td class="px-2 py-2 md:px-4 md:py-3 text-right text-sm font-medium hidden md:table-cell">
                                <inertia-link :href="route('projects.show', {project: item.id})" class="text-indigo-600 hover:text-indigo-900">View</inertia-link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <pagination class="mt-6" :links="list.links" />
        </div>
        <inertia-link :href="route('projects.create')">
            <button
                class="p-0 w-16 h-16 bg-yellow-600 rounded-full hover:bg-yellow-700 active:shadow-lg mouse shadow transition ease-in duration-200 focus:outline-none absolute bottom-6 right-6">
                <svg viewBox="0 0 20 20" enable-background="new 0 0 20 20" class="w-6 h-6 inline-block">
                    <path fill="#FFFFFF" d="M16,10c0,0.553-0.048,1-0.601,1H11v4.399C11,15.951,10.553,16,10,16c-0.553,0-1-0.049-1-0.601V11H4.601
                                    C4.049,11,4,10.553,4,10c0-0.553,0.049-1,0.601-1H9V4.601C9,4.048,9.447,4,10,4c0.553,0,1,0.048,1,0.601V9h4.399
                                    C15.952,9,16,9.447,16,10z"/>
                </svg>
            </button>
        </inertia-link>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import SearchInput from "@/Components/SearchInput";
import Pagination from "@/Components/Pagination";

export default {
    components: {
        AppLayout,
        Pagination,
        SearchInput
    },
    data() {
        return {
            searchKeyword: this.keyword ?? "",
            searchMessage: ""
        };
    },
    methods: {
        search(keyword) {
            this.$inertia.get(this.route('projects.index'), {search: keyword}, {
                only: ['list', 'keyword'],
                preserveState: true
            });
            this.searchMessage = "";
        },
    },
    watch: {
        // whenever question changes, this function will run
        searchKeyword: function (newValue, oldValue) {
            this.searchMessage = "Typing...";
            this.debouncedSearch(newValue)
        }
    },
    created: function (keyword) {
        this.debouncedSearch = _.debounce(this.search, 500)
    },
    props: {
        keyword: String|null,
        list: Object
    }
};
</script>
