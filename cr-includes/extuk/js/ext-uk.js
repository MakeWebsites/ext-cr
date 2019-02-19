var Url_ext = 
    'http://datapoint.metoffice.gov.uk/public/data/txt/wxobs/ukextremes/json/latest?key=67b100ab-ec19-4637-a869-5122fe285d12';
            new Vue ({
            el: '#ext-uk',
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


