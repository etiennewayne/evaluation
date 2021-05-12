<template>
    <div>
        <div class="hero is-fullheight-with-navbar">
            <div class="hero-body">
                <div class="container has-text-centered">
                    <div class="home-logo animate__animated animate__bounceIn">
                        <img src="/img/home-logo.svg" style="height: 300px"/>
                    </div>

                    <div class="welcome-text animate__animated animate__backInLeft">
                        ONLINE FACULTY PERFORMANCE EVALUATION SYSTEM
                    </div>

                    <div class="buttons is-centered animate__animated animate__backInLeft">
                        <b-button class="is-primary mt-4" icon-pack="fa" icon-left="arrow-right" tag="a" href="/login">
                            START EVALUATION
                        </b-button>
                    </div>
                </div>
            </div>
        </div>

    </div><!--root div-->
</template>

<script>
export default {
}
</script>

<style scoped>

.home-wrapper {
    display: flex;
    justify-content: center;
    flex-direction: column;
    align-items: center;
    margin: 5px 5px 5px 5px;
}

.home-logo{
    width: 100%;
}

.welcome-text{
    font-size: 20px;
    font-weight: bold;
}



@media only screen and (max-width: 768px) {
    .home-wrapper {
        background-color: red;
    }
}


</style>
