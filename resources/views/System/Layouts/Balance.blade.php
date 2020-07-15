
                    <div class="col-lg-12 col-xl-12">
                      <div class="row">
                        <div class="col-sm-12 col-md-6 ">
                          <div class="box">
                            <div class="item">
                              <div class="item-bg light h6">
                                </div>
                                    <div class="p-a p-t-sm pos-rlt">
                                    <img src="system/images/icon/redbox.png" alt="." class="w-64" style="margin-bottom: -3.2rem">
                                </div>
                            </div>
                            <div class="p-a-md bg-logo">
                              <div class="m-t">
                                  <table class="table m-a-0 table-box">
                                    <tbody>
                                      <tr class="border-bt">
                                        <td class="text-danger item-title">RBD</td>
                                        <td>{{$balance->RBD+0}} RBD </td>
                                      </tr>
                                      <tr>
                                        <td>$ {{$rate['RBD']+0}}</td>
                                        <td class="item-title">
                                          ~ {{ ($balance->RBD * $rate['RBD'])+0 }} USD
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                          <div class="box">
                            <div class="item">
                              <div class="item-bg light h6">
                                </div>
                                    <div class="p-a p-t-sm pos-rlt">
                                    <img src="system/images/icon/usd.png" alt="." class="w-64" style="margin-bottom: -3.2rem">
                                </div>
                            </div>
                            <div class="p-a-md bg-logo">
                              <div class="m-t">
                                  <table class="table m-a-0 table-box">
                                    <tbody>
                                      <tr class="border-bt">
                                        <td class="text-warn item-title">USD</td>
                                        <td>$ {{$balance->USD+0}}</td>
                                      </tr>
                                      <tr>
                                        <td>$ 1</td>
                                        <td class="text-warn item-title"><button class="btn btn-info btn-rounded deposit" data-id="2">Deposit ETH</button></td>
                                      </tr>
                                    </tbody>
                                  </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>