// AOS.init({
//     offset: 200,
//     duration: 1200,
// });

// $(function () {
//     $('[data-toggle="tooltip"]').tooltip()
// })

const nav = {
    template:
        '<nav class="navbar navbar-expand-lg navbar-light"><span class="text-light" style="font-size: 20px;min-width:200px">{{ hometitle }}</span> <span class="navbar-toggler ml-auto border-0"><span class="text-light fa fa-bars" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBackdrop" style="font-size: 33px;"></span></span><div class="collapse navbar-collapse pl-lg-5"><ul class="navbar-nav m-auto mt-2 mt-lg-0 text-left text-lg-center mr-1 pl-lg-5"> <li v-for="mid in mids" class="nav-item"> <a class="nav-link text-light" :href="mid.link">{{mid.name}}</a></li></ul><ul class="navbar-nav mr-0 text-left text-lg-right p-0"><li v-for="end in ends" class="nav-item"><a class="nav-link text-light" :href="end.link">{{end.name}}</a></li></ul></div></nav>      <div class="offcanvas offcanvas-start" tabindex="-1" data-bs-backdrop="false" id="offcanvasWithBackdrop" ><div class="offcanvas-header bg-dark"><h5 class="offcanvas-title text-light" id="offcanvasWithBackdropLabel">{{ hometitle }} Menu</h5> <button type="button" style="font-size:30px" class="fa border-0 fa-times bg-transparent text-light" data-bs-dismiss="offcanvas"></button></div> <div class="offcanvas-body pt-0"> <ul class="navbar-nav mt-2 mt-lg-0 mr-1"> <li v-for="mid in mids" class="nav-item border-bottom p-2"> <a class="nav-link text-dark" :href="mid.link">{{mid.name}}</a></li></ul><ul class="navbar-nav  p-0"><li v-for="end in ends" class="nav-item border-bottom p-2"><a class="nav-link text-dark" :href="end.link">{{end.name}}</a></li></ul> </div> </div>',
    data() {
        return {
            hometitle : 'Myanmar Book',
            mids      : [
                {name:'Home',link:'index.php'},
                {name:'About',link:'#'}
            ],
            ends      : [
                {name:'Register',link:'register.php'},
                {name:'Login',link:'login.php'}
            ],

        }
    },
    methods: {
        
    },

}



Vue.createApp(nav).mount('#nav');





