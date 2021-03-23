<template>
    <div>
        <div class="hero is-fullheight">
            <div class="hero-body">
                <div class="panel">
                    <div class="panel-heading">
                        SECURITY CHECK
                    </div>
                    <div>
                        <b-field label="Username">
                            <b-input placeholder="Username" required type="text" v-model="fields.username"></b-input>
                        </b-field>
                    </div>
                </div>
            </div>
            
        </div>
        
    </div>
</template>

<script>
export default {
    data(){
        return{
            
        }
    }
}
</script>