<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<div id='extuk'>
        <h3>Latest weather extremes in UK</h3>
        <select v-model="region">
            <option disabled value="">Select region</option>
            <option v-for="region in regions"  :key="region.id" v-bind:value = "region">{{ region.name }}</option>
        </select>
    <div v-if="region">
        <table class="table table-responsive">
            <tr>
                <td>
                    Date: <strong>{{exDate}}</strong>
                </td>
                <td>
                    Region: <strong>{{region.name }}</strong>
                </td>
            </tr>
        </table>       
    </div>
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
            <button v-if="region != ''" @click="newRegion">Select another region</button>
                    
    </div>
    
    <script>
    var Url_ext = 
    'http://datapoint.metoffice.gov.uk/public/data/txt/wxobs/ukextremes/json/latest?key=67b100ab-ec19-4637-a869-5122fe285d12';
            new Vue ({
            el: '#extuk',
            created: function() {
                this.extremes = this.getExtremes();                     
            },
            data: {
                regions: [],
                extDate: '',
                region: ''
                },
                methods: {
                   async getExtremes() {
                        try { 
                            const data = await fetch(Url_ext);
                            const json = await data.json();
                            this.regions = json.UkExtremes.Regions.Region;
                            this.exDate = json.UkExtremes.extremeDate;
                            // sort by name
                                this.regions.sort(function(a, b) {
                                var nameA = a.name.toUpperCase(); // ignore upper and lowercase
                                var nameB = b.name.toUpperCase(); // ignore upper and lowercase
                                if (nameA < nameB) {
                                    return -1;
                                }
                                if (nameA > nameB) {
                                    return 1;
                                }
                                // names must be equal
                                return 0;
                                });
                        } catch (e) {
                    // Something wrong
                            }
                     },
                     newRegion() {
                         this.region = '';
                        }                
            }
        })
    </script>
 
 