<template>
    <b-navbar class="is-dark">
        <template #brand>
            <b-navbar-item>
               <span style="font-weight: bold;">ADMINISTRATOR</span>
            </b-navbar-item>
        </template>
        <template #start>
            <b-navbar-item href="/cpanel-home">
                Home
            </b-navbar-item>
            <b-navbar-item href="/cpanel-academicyear">
                Academic Year
            </b-navbar-item>
            <b-navbar-item href="/cpanel-category">
                Categories
            </b-navbar-item>
            <b-navbar-item href="/cpanel-criteria">
                Criteria
            </b-navbar-item>
            <b-navbar-item href="/cpanel-schedule">
                Schedule
            </b-navbar-item>
            <b-navbar-item href="/cpanel-user">
                Users
            </b-navbar-item>
            <b-navbar-dropdown label="Reports">
                <b-navbar-item href="/cpanel-report/faculty-report">
                    Faculty Report
                </b-navbar-item>
<!--                <b-navbar-item href="#">-->
<!--                    Contact-->
<!--                </b-navbar-item>-->
            </b-navbar-dropdown>
        </template>

        <template #end>
            <b-navbar-item tag="div">
                <div class="buttons">
                    <b-button class="button is-danger" icon-right="sign-out" icon-pack="fa" @click="logout">
                        LOGOUT
                    </b-button>
                </div>
            </b-navbar-item>
        </template>
    </b-navbar>
</template>

<script>
export default {
    methods: {
        logout(){
            axios.post('/logout').then(res =>{
                window.location = '/';
            })
        }
    }
}
</script>
