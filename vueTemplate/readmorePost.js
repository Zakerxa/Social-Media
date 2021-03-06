Vue.component('readmore-post',{
    data: function () {
      return {
        readmorepost       : true,
      }
    },
    methods:{

    },
    props: [
        'post','link','index'
    ],
    template: `
    <div>
       <div  class="p-0" style="white-space:pre-wrap;font-size:15px;">{{post.substr(0, 170)}}<span @click="readmorepost = !readmorepost" :data-bs-target="'#readmore'+index" data-bs-toggle="collapse" class="text-muted d-inline-block" v-if="post.length > 135 && readmorepost">...See More</span><span class="collapse" :id="'readmore'+index" data-parent="#accordion">{{post.substr(170)}}
          <div v-if="link.length > 0">========== Link Address ==========
            <a v-for="url in link" target="blank" class="d-block p-1" :href="url">{{url}}</a>
          </div>
       </span>
         
       </div>
  </div>`
  });
