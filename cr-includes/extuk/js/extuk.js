Vue.component('extukt', {
    props: {
        region: {}
    },
    template: `
    <div v-if="region" >
    <div class="table table-responsive">
        <table  class="table-bordered table-hover" >
            <thead class="thead-light">
                <th style="width:10%" scope="col">Location</th>
                <th style="width:10%" scope="col">Met Variable</th> 
                <th style="width:5%" class="text-right" scope="col">Extreme</th>
            </thead>
            <tr v-for="extreme in region.Extremes.Extreme">
                <td>{{extreme.locationName}}</td>
                <td>
                    <span v-if="extreme.type==='HRAIN'">Rainfall</span>
                    <span v-else-if="extreme.type==='HSUN'">Sunshine time</span>
                    <span v-else-if="(extreme.type==='HMINT' || extreme.type==='LMINT')">Minimum Temperature</span>
                    <span v-else-if="(extreme.type==='HMAXT' || extreme.type==='LMAXT')">Maximum Temperature</span>
                </td>
                <td class="text-right">{{extreme.$}} 
                    <span v-if="extreme.type==='HRAIN'">mm</span>
                    <span v-else-if="extreme.type==='HSUN'">hours</span>
                    <span v-else>&#8451;</span>
                </td>
            </tr>
        </table>
    </div>
</div>
    `
})