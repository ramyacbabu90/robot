        <div class="row">
          <div class=" col-md-12">
            <div class="card">
              <div class="card-header card-header-tabs card-header-primary">
                
              </div>


              <div class="card-body table-responsive" style="width: 100%;">
               <table class="table">
                <thead class=" text-primary">

                  <th>
                    #
                  </th>
                  <th>
                    Model
                  </th>
                  <th>
                    Serial Number
                  </th>
                  <th>
                    Manufactured Date
                  </th>
                  <th>
                   category
                  </th>
                </thead>
                  <tbody>
                     @foreach ($data as $key=>$prd)
                     <tr>
                      <td>{{$key+1}}</td>
                      <td>
                        {{ $prd['model'] }}
                      </td>
                      <td>
                         {{ $prd['serialNumber'] }}
                      </td>
                      <td>
                         {{ $prd['manufacturedDate'] }}
                      </td> 
                      <td>
                         {{ $prd['category'] }}
                      </td>
                      
                    </tr>
                     @endforeach
                  </tbody>

                </table>
              </div>
            </div>

          </div>
          
        </div>
