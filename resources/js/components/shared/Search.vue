<template>
    <div>
        
        <input 
            type="search" 
            v-model="query"
            placeholder="search" 
            class="border rounded px-2 py-1 border-gray-300 text-gray-700"/>
            
    </div>
</template>

<script>
    import Fuse from 'fuse.js'

    export default {
        props: {
            collection: {
                type: Array,
                required: true
            },
            fields: {
                type: Array,
                required: true,
            }
        },
        
        data(){
            return {
                fuse: '',
                query: '',
            }
        },

        mounted() {
            this.fuse = new Fuse(this.collection, {
                shouldSort: true,
                // includeMatches: true,
                threshold: 0.3,
                location: 0,
                distance: 100,
                maxPatternLength: 32,
                minMatchCharLength: 1,
                keys: this.fields.map(f => f.name)
            });
        },

        watch: {
            query() {
                this.search();
            }
        },

        methods: {
            search(){
                let results = null;
                let matches = null;
                if (this.query.length > 0) {
                    results = this.fuse.search(this.query);
                    // results = this.addMatches(results);
                }
                
                this.$emit('search', results);
            },
            // addMatches(results){
            //     if (!results.length) return results;
            //     return  results.map(r => ({ ...r.item, matches: r.matches }));
            // }
        }
    }
</script>

<style>

    input[type="search"]:focus {
       @apply border-teal-500; 
    }

</style>