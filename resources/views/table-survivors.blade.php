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
                    Survivor Is
                  </th>
                  <th>
                    Name
                  </th>
                  <th>
                    Age
                  </th>
                  <th>
                   Gender
                  </th>
                  <th>
                   Last Location
                  </th>
                  <th>
                   Created At
                  </th>
                  <th>
                   Status
                  </th>
                </thead>
                  <tbody>
                     @foreach ($data as $key=>$prd)
                     <tr>
                      <td>{{$key+1}}</td>
                      <td>
                        {{ $prd['survivor_id'] }}
                      </td>
                      <td>
                         {{ $prd['name'] }}
                      </td>
                      <td>
                         {{ $prd['age'] }}
                      </td> 
                      <td>
                         {{ $prd['gender'] }}
                      </td>
                      <td>
                         ({{ $prd['lat'] .','.$prd['lng']}})
                      </td>
                      <td>
                         {{ date('Y-m-d',strtotime($prd['created_at'])) }}
                      </td>
                      <td>
                         @if($prd['is_infected'])
                         <span class="badge badge-danger" style="color: #fff;background-color: #dc3545";>Infected</span>
                         @else
                         <span class="badge badge-success" style="color: #fff;background-color: #28a745;">Not Infected</span>
                         @endif

                      </td>
                      
                    </tr>
                     @endforeach
                  </tbody>

                </table>
              </div>
            </div>

          </div>
          
        </div>
