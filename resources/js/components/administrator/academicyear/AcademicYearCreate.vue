<template>

<div>
    <div class="container">


        <div class="columns">
            <div class="column">
                <b-field label="AY Code">
                    <b-input type="text" v-model="fields.aycode"
                    required>
                    </b-input>
                </b-field>
            </div>
        </div>


    </div><!--close container-->
</div>
    
</template>

<script>
export default {
    data(){
        return{
            fields: {},

        }
    },
    methods: {

    },

}
</script>