<template>
	<div>
		<div class="centerModal">
			<div class="modalInner">
				<div class="header">
					<h3>新建合同</h3>
					<i class="icon iconfont" @click="closeNewContract">&#xe60f;</i>
				</div>
				<div class="body">
					<div class="newContract">
						<div class="row">
							<div class="col-xs-3"><span>*</span>合同名称</div>
							<div class="col-xs-9">
								<input type="text" placeholder="请输入客户名称" v-model="newContract.contract_name"/>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3">合同编号</div>
							<div class="col-xs-9">
								<input type="text" placeholder="请输入客户编号" v-model="newContract.contract_number" />
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3"><span>*</span>客户名称</div>
							<div class="col-xs-9" id="customParent">
								<input type="text" placeholder="请选择客户名称" @focus="changeShowlianxiang(1)"
                                      @blur="changeShowlianxiang(2)" @input="inputCustom" v-model="newContract.custom_name" />
                                <div class="customModel" v-show="showLianxiang">
                                    <p @click="setCustom(item.id,item.custom_name)" v-show="item.custom_name.indexOf(newContract.custom_name)>-1"
                                       v-for="(item,key) in searchCustomerArr">{{item.custom_name}}</p>
                                </div>
								<span class="choose" @click="selectCustomer">选择</span>
								<ul class="preset">
								<!-- 	<li class="active">西安</li>
									<li>西安朋客信息科技有限公司</li>
									<li>西安朋客信息科技有限公司</li> -->
								</ul>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3">合同标签</div>
							<div class="col-xs-9">
								<input type="text" placeholder="请选择合同标签" disabled v-model="newContract.label_name" />
								<span class="choose" @click="selectLabels">选择</span>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3">合同类型</div>
							<div class="col-xs-9">
								<select v-model="newContract.contract_type">
									<option value="1">普通合同</option>
									<option value="2">周期合同</option>
									<option value="3">框架合同</option>
								</select>
							</div>
						</div>
						
						<div class="row">
							<div class="col-xs-3"><span>*</span>合同日期</div>
							<div class="col-xs-9">
								<input type="date" value="" @input="setContractDate" v-model="newContract.contract_date"/>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3"><span>*</span>到期日期</div>
							<div class="col-xs-9">
								<input type="date" value="" @input="setMaturityDate" v-model="newContract.maturity_date"/>
							</div>
						</div>
						<div class="row" v-show="newContract.contract_type==1">
							<div class="col-xs-3"><span>*</span>合同金额</div>
							<div class="col-xs-9">
								<input type="text" placeholder="请输入合同金额" v-model="newContract.contract_money" />
							</div>
						</div>
						<!-- 周期合同 -->
						<div class="row" v-show="newContract.contract_type==2">
							<div class="col-xs-3"><span>*</span>回款周期</div>
							<div class="col-xs-9">
								<select v-model="newContract.huikuanzhouqiId">
									<option value="1">每月</option>
									<option value="2">每季</option>
									<option value="3">每年</option>
								</select>
							</div>
						</div>
						<div class="atte" v-show="newContract.contract_type==2">
							回款期次：<span>{{cycle}}</span>
						</div>
						<div class="row" v-show="newContract.contract_type==2">
							<div class="col-xs-3"><span>*</span>首次回款日期</div>
							<div class="col-xs-9">
								<input type="date" @input="setFirstDate" v-model="newContract.firstDate"/>
							</div>
						</div>
						<div class="row" v-show="newContract.contract_type==2" >
							<div class="col-xs-3"><span>*</span>每期金额</div>
							<div class="col-xs-6">
								<input type="text" placeholder="请输入每次金额" v-model="newContract.eachMoney"/>
							</div>
							<div class="bizhong">
								<select v-model="newContract.currency_id">
									<option value="1">人民币</option>
									<option value="2">美元</option>
									<option value="4">新台币</option>
									<option value="7">欧元</option>
									<option value="8">英镑</option>
									<option value="9">加拿大元</option>
									<option value="10">澳门币</option>
									<option value="11">澳大利亚元</option>
									<option value="12">泰铢</option>
									<option value="13">新西兰元</option>
									<option value="14">巴西雷亚尔</option>
									<option value="15">瑞士法郎</option>
									<option value="16">印度卢比</option>
									<option value="17">俄罗斯卢布</option>
									<option value="18">瑞典克朗</option>
									<option value="19">越南盾</option>
									<option value="20">南非兰特</option>
									<option value="21">菲律宾比索</option>
								</select>
							</div>
						</div>
						<div class="atte" v-show="newContract.contract_type==2">
							合同金额：<span>￥{{newContract.eachMoney*cycle | numberFormat}}</span>
						</div>
						<div class="row" v-show="newContract.contract_type==2">
							<div class="col-xs-3">周期提醒</div>
							<div class="col-xs-9">
								<select v-model="newContract.advance_remind">
									<option value="7">提前7天</option>
									<option value="6">提前6天</option>
									<option value="5">提前5天</option>
									<option value="4">提前4天</option>
									<option value="3">提前3天</option>
									<option value="2">提前2天</option>
									<option value="1">提前1天</option>
									<option value="0">不提醒</option>
								</select>
							</div>
						</div>
						<!-- 周期合同 -->

						<!-- 框架合同 -->
						<div class="row" v-show="newContract.contract_type==3">
							<div class="col-xs-3">预收款</div>
							<div class="col-xs-6">
								<input type="text" placeholder="请输入合同预收款" v-model="newContract.advance_money" />
							</div>
							<div class="bizhong">
								<select v-model="newContract.currency_id">
									<option value="1">人民币</option>
									<option value="2">美元</option>
									<option value="4">新台币</option>
									<option value="7">欧元</option>
									<option value="8">英镑</option>
									<option value="9">加拿大元</option>
									<option value="10">澳门币</option>
									<option value="11">澳大利亚元</option>
									<option value="12">泰铢</option>
									<option value="13">新西兰元</option>
									<option value="14">巴西雷亚尔</option>
									<option value="15">瑞士法郎</option>
									<option value="16">印度卢比</option>
									<option value="17">俄罗斯卢布</option>
									<option value="18">瑞典克朗</option>
									<option value="19">越南盾</option>
									<option value="20">南非兰特</option>
									<option value="21">菲律宾比索</option>
								</select>
							</div>
						</div>
						<div class="row" v-show="newContract.contract_type==3">
							<div class="col-xs-3"><span>*</span>收款方式</div>
							<div class="col-xs-9">
								<div class="hkzq">
									<select v-model="newContract.payment_type">
										<option value="1">每月</option>
										<option value="2">每季度</option>
										<option value="3">每年</option>
									</select>
									<span v-show="newContract.payment_type!=1">/</span>
									
									<select v-show="newContract.payment_type == 3" v-model="newContract.each_month">
										<option value="1">1月</option>
										<option value="2">2月</option>
										<option value="3">3月</option>
										<option value="4">4月</option>
										<option value="5">5月</option>
										<option value="6">6月</option>
										<option value="7">7月</option>
										<option value="8">8月</option>
										<option value="9">9月</option>
										<option value="10">10月</option>
										<option value="11">11月</option>
										<option value="12">12月</option>
									</select>
									 <select v-show="newContract.payment_type == 2" v-model="newContract.each_season">
			                            <option value="1">第1个月</option>
			                            <option value="2">第2个月</option>
			                            <option value="3">第3个月</option>
			                        </select>
									<span>/</span>
									 <select v-model="newContract.each_day">
			                            <option value="1">1日</option>
			                            <option value="2">2日</option>
			                            <option value="3">3日</option>
			                            <option value="4">4日</option>
			                            <option value="5">5日</option>
			                            <option value="6">6日</option>
			                            <option value="7">7日</option>
			                            <option value="8">8日</option>
			                            <option value="9">9日</option>
			                            <option value="10">10日</option>
			                            <option value="11">11日</option>
			                            <option value="12">12日</option>
			                            <option value="13">13日</option>
			                            <option value="14">14日</option>
			                            <option value="15">15日</option>
			                            <option value="16">16日</option>
			                            <option value="17">17日</option>
			                            <option value="18">18日</option>
			                            <option value="19">19日</option>
			                            <option value="20">20日</option>
			                            <option value="21">21日</option>
			                            <option value="22">22日</option>
			                            <option value="23">23日</option>
			                            <option value="24">24日</option>
			                            <option value="25">25日</option>
			                            <option value="26">26日</option>
			                            <option value="27">27日</option>
			                            <option value="28">28日</option>
			                            <option value="29">29日</option>
			                            <option value="30">30日</option>
			                            <option value="31">31日</option>
                        			</select>
								</div>
							</div>
						</div>
						<!-- 框架合同 -->
						<div class="row">
							<div class="col-xs-3">联系人</div>
							<div class="col-xs-9">
								<input type="text" v-model="newContract.linkmanId" placeholder="请输入联系人" value="" />
								<i class="icon iconfont dj" @click="selectLinkMan">&#xe623;</i>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3"><span>*</span>跟进人</div>
							<div class="col-xs-9">
								<input type="text" placeholder="请选择跟进人" value="" />
								<i class="icon iconfont dj" @click="selectFollow">&#xe604;</i>
								<div class="genjinren">
									<div class="level">
										<ul >
											<li><i class="icon iconfont">&#xe622;</i><i class="icon iconfont">&#xe604;</i>西安分公司
												<ul>
													<li>
														<i class="icon iconfont">&#xe622;</i><i class="icon iconfont">&#xe604;</i>碑林区办事处
													</li>
												</ul>
											</li>
										</ul>
										<ul>
											<li><i class="icon iconfont">&#xe681;</i><i class="icon iconfont">&#xe604;</i>广东分公司</li>
										</ul>
										<ul>
											<li><i class="icon iconfont">&#xe681;</i><i class="icon iconfont">&#xe604;</i>广州分公司</li>
										</ul>
									</div>
									<div class="persons">
										<ul>
											<li><i class="icon iconfont">&#xe628;</i>王小明</li>
											<li><i class="icon iconfont">&#xe628;</i>王小明</li>
											<li><i class="icon iconfont">&#xe628;</i>王小明</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3">产品信息</div>
							<div class="col-xs-9 chanpin">
								<table>
									<thead>
										<tr>
											<th>产品名称</th>
											<th>单价</th>
											<th>计价单位</th>
											<th>数量</th>
											<th><i class="icon iconfont">&#xe616;</i></th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><span>1</span><input type="text" value=""></td>
											<td><input type="text" value="￥562300.00"></td>
											<td>
												<input type="text" value="台">
											</td>
											<td>
												<input type="text" value="5">
											</td>
											<td>
												<i class="icon iconfont xiazai">&#xe616;</i>
												<i class="icon iconfont dele">&#xe610;</i>
											</td>
										</tr>
									</tbody>
								</table>
								<div class="none">
									<div class="div1">暂无产品信息</div>
									<div>合计：0元</div>
									<span class="choose">选择</span>
								</div>
								
								
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3">备注</div>
							<div class="col-xs-9">
								<textarea name="" id="" v-model="newContract.remark"></textarea>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3">附件</div>
							<div class="col-xs-9 file">
								<table v-show="this.fileMap.length>0">
									<thead>
										<tr>
											<th>文件名称</th>
											<th>文件大小</th>
											<th>操作</th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="item,key in this.fileMap">
											<td>{{item.name}}</td>
											<td>{{item.size}}</td>
											<td>
												<i class="icon iconfont yulan" @click="yulan(key)">&#xe660;</i>
												<i class="icon iconfont xiazai">&#xe62a;</i>
												<i class="icon iconfont dele" @click="delImg(key)">&#xe612;</i>
											</td>
										</tr>
									</tbody>
								</table>
								<div class="upload"><p>+点击添加附件</p>
								<input type="file" ref="files" multiple="true" accept="image/png,image/gif,image/jpeg" @change="upload"/></div>
							</div>
						</div>
					</div>
				</div>
				<div class="footer">
					<button class="btn cancel" @click="closeNewContract">取消</button>
					<button class="btn confirm" @click="sengData()">确定</button>
				</div>
			</div>
		</div>
		<!-- 选择客户部分弹框 -->
		<selectCustomers v-show="showSelectCustom" @closeSelectCustom="hiddenSelectCustom" @customInfo="ChooseCustomer"></selectCustomers>
		<!--选择合同标签弹框-->
		<selectLabels v-show="showSelectLabel" @closeSelectLabelss="hiddenSelectLabel" @ChoosedLabels="ChoosedLabels"></selectLabels>
		<!--选择联系人-->
		<!-- <selectLinkman v-show="showSelectLinkMan" @closeSelectLinkman="hiddenSelectLinkman" @ChoosedLabels="ChoosedLabels"></selectLinkman> -->
		<!-- 手动添加回款计划部分弹框 -->
		<manual v-if="showManual" :sendHuikuanDate="newContract.contract_date" :sendHuikuanMoney="newContract.contract_money" :sendHuikuanMaDate="newContract.maturity_date" :sendContractId="this.contractId" @closeManual="hiddenManual" @qiehuanzidonghuikuan="openZidong" @closeManualAndNewContractComponents="closeManualAndNewContractComponents"></manual >
		<!-- 自动添加回款计划部分弹框 -->
		<automatic v-if="showAutoMatic" :sendHuikuanDate="newContract.contract_date" :sendHuikuanMoney="newContract.contract_money" :sendHuikuanMaDate="newContract.maturity_date" :sendContractId="this.contractId" @closeAutoMatic="hiddenAutoMatic" @qiehuanshoudonghuikuan="openShoudong" @closeAutoMacticAndNewContractComponents="closeAutoMacticAndNewContractComponents"></automatic>
	</div>
</template>

<script>
	import {mapState, mapMutations} from 'vuex'
	import {host, imghost} from '../../../config/config.js'
	import selectCustomers from '../../../components/selectCustomers/selectCustomers.vue'
	import selectLabels from '../../../components/selectCustomers/selectLabels.vue'
	import manual from '../../../components/manual/manual.vue'
	import automatic from '../../../components/automatic/automatic.vue'
	// import selectLinkman from '../../components/selectCustomers/selectLinkman.vue'
	import ccl from '../../../common/ccl.js'
	import axios from 'axios'
	export default{
		data(){
			return {
				host,
				imghost,
				newContract:{
					contract_type:'1',
					files:[],
					currency_id:1,
                    custom_name:'',
                    payment_type:1,
                    each_season:1,
                    each_month:1,
                    each_day:1,
				},
				contractInfo:[],
				showSelectCustom:false,
				showSelectLabel:false,
				showSelectLinkMan:false,
				showManual:false,
				showAutoMatic:false,
				fileMap:[],
				yulanFiles:[],
				searchCustomerArr:[],
				contractId:'',
                showLianxiang:false,
			}
		},
		components: {
            selectCustomers,
            selectLabels,
            manual,
            automatic,
            // selectLinkman,
        },
        mounted(){
        	this.getCutomer()
        },
        computed:{
			//根据选择收账方式来改变世界
			cycle(){
                let conDate = this.newContract.contract_date; //合同时间
                let arrDate = this.newContract.maturity_date; //到期时间
                let firstDate = this.newContract.firstDate
                this.I(arrDate)
                this.I(firstDate)
                if(arrDate == '' || arrDate == undefined){
                    return;
                }
                if(firstDate == '' || firstDate == undefined){
                    return;
                }
                if(arrDate>firstDate){
                    let aY = arrDate.slice(0,4)
                    let am = arrDate.slice(5,7)
                    let ad = arrDate.slice(-2)
                    let fY = firstDate.slice(0,4)
                    let fm = firstDate.slice(5,7)
                    let fd = firstDate.slice(-2)
                    
                    if(this.newContract.huikuanzhouqiId == 1){
                        if(ad >= fd){
                            return (aY-fY)*12+(am-fm)+1
                        }else{
                            return (aY-fY)*12+(am-fm)
                        }
                    }else if(this.newContract.huikuanzhouqiId == 2){
                        if(ad >= fd){
                            if(am > fm){
                                return (aY-fY)*4+Math.floor((am-fm)/3)+1
                            }else{
                                return (aY-fY)*4+Math.floor((am-fm)/3)
                            }
                        }else{
                            if(am > fm){
                                return (aY-fY)*4+Math.floor((am-fm)/3)
                            }else{
                                return (aY-fY)*4+Math.floor((am-fm)/3)-1
                            }
                        }
                    }else if(this.newContract.huikuanzhouqiId == 3){
                        if(am > fm || (am == fm && ad>= fd)){
                            return ay - fy +1
                        }else{
                            return ay-fy
                        }
                    }
                }else{
                    return 0
                }
				
			}
		},
		methods:{
            
            setMaturityDate(e){
                this.$set(this.newContract,'maturity_date',e.target.value)
            },
            setContractDate(e){
                this.$set(this.newContract,'contract_date',e.target.value)
            },
            setFirstDate(e){
                this.$set(this.newContract,'firstDate',e.target.value)
            },
			getCutomer(){
				 this.$http("GET", '/custom/get_custom_list.php').then(res => {
                    this.searchCustomerArr = res.data
                }).catch(err => {
                
                })
			},
            changeShowlianxiang(val){
			    if(val == 1){
			        this.showLianxiang = true;
                }
                if(val == 2){
			        setTimeout(()=>{
                        this.showLianxiang = false;
                    },200)
                }
            },
			sengData(){

				let sendData = this.newContract

                let newForm = new FormData()

                if (sendData.contract_name == '' || sendData.contract_name == undefined) {
                    alert('合同名称不能为空');
                    return;
                }
                if (sendData.custom_id == '' || sendData.custom_id == undefined) {
                    alert('客户名称不能为空');
                    return;
                }
                if (sendData.contract_date == '' || sendData.contract_date == undefined) {
                    alert('合同日期不能为空');
                    return;
                }
                if ((sendData.contract_money == '' || sendData.contract_money == undefined) && sendData.contractType == 1) {
                    alert('合同金额无效');
                    return;
                }
                if ((sendData.maturity_date == '' || sendData.maturity_date == undefined) && sendData.contractType != 1) {
                    alert('到期日期不能为空');
                    return;
                }
                if ((sendData.firstDate == '' || sendData.firstDate == undefined) && sendData.contractType == 2) {
                    alert('首次回款日期不能为空');
                    return;
                }
                if ((sendData.eachMoney == '' || sendData.eachMoney == undefined) && sendData.contractType == 2) {
                    alert('每期回款金额不能为空');
                    return;
                }
                //公共参数
                let contract_name = sendData.contract_name ? sendData.contract_name : ''
                let contract_number = sendData.contract_number ? sendData.contract_number : ''
                let custom_id = sendData.custom_id ? sendData.custom_id : ''
                let label_id = sendData.label_id ? sendData.label_id : ''
                let contract_type = sendData.contract_type ? sendData.contract_type : ''
                let contract_date = sendData.contract_date ? sendData.contract_date : ''
                let maturity_date = sendData.maturity_date ? sendData.maturity_date : ''
                let linkman = sendData.linkman ? sendData.linkman : ''
                let follow_id = sendData.follow_id ? sendData.follow_id : ''
                let depart_id = sendData.depart_id ? sendData.depart_id : ''
                let remark = sendData.remark ? sendData.remark : ''
                let product_info = sendData.product_info ? endData.product_info : ''
                //普通合同
                let contract_money = sendData.contract_money ? sendData.contract_money : ''
                //周期合同
                let huikuanzhouqiId = sendData.huikuanzhouqiId ? sendData.huikuanzhouqiId : 1
                let firstDate = sendData.firstDate ? sendData.firstDate : ''
                let eachMoney = sendData.eachMoney ? sendData.eachMoney : ''
                let advance_remind = sendData.advance_remind ? sendData.advance_remind : ''
                let reminder = 0;
                if(advance_remind!=0)
                {
                	reminder = 1 ;
                }
                //框架合同
                let advance_money = sendData.advance_money ? sendData.advance_money : ''
                let currency_id = sendData.currency_id ? sendData.currency_id : 1
                let payment_type = sendData.payment_type ? sendData.payment_type : ''
                let three_type = sendData.each_month ? sendData.each_month : ''
                let two_type = sendData.each_season ? sendData.each_season : ''
                let each_day = sendData.each_day ? sendData.each_day : ''
                let each_month = payment_type == 2 ? two_type : payment_type == 3 ? three_type : '1'

                if (sendData.files && sendData.files.length > 0) {
                    for (let i = 0; i < sendData.files.length; i++) {
                        newForm.append("image" + i, sendData.files[i])
                    }
                }
                newForm.append('contract_name', contract_name)
                newForm.append('contract_number', contract_number)
                newForm.append('custom_id', custom_id)
                newForm.append('label_id', label_id)
                newForm.append('contract_type', contract_type)
                newForm.append('contract_date', contract_date)
                newForm.append('maturity_date', maturity_date)
                newForm.append('remark', remark)
                newForm.append('currency_id', currency_id)
                newForm.append('linkman', linkman)
                newForm.append('followup', 1) //follow_id
                newForm.append('depart_id', 1) //depart_id

                if (contract_type == 1) {
                    newForm.append('contract_money', contract_money)
                } else if (contract_type == 2) {
                    newForm.append('payment_cycle', huikuanzhouqiId)
                    newForm.append('firstPayment', firstDate)
                    newForm.append('each_money', eachMoney)
                    newForm.append('reminder', reminder)
                    newForm.append('advance_remind', advance_remind)
                } else if (contract_type == 3) {
                    newForm.append('advance_money', advance_money)
                    newForm.append('payment_type', payment_type)
                    newForm.append('each_month', each_month)
                    newForm.append('each_day', each_day)
                }
                // console.log('sumtt')
                this.$http('FORM', '/contract/add_contract.php', newForm).then(res => {

                    if (res.code == 0) {
                        this.contractId = res.contract_id
                        // console.log(id)
                        if (contract_type == 1) {
                        	
                          // this.showManual = true
                          this.showAutoMatic = true


                        } else {
                        	this.$emit('closeNewContract');
                        }
                    }
                }).catch(err => {
                    this.I(err)
                })
			},
			//选择客户组建显示
			selectCustomer(){

				this.showSelectCustom = true
			},
			//选择客户渲染
			ChooseCustomer(val){
				this.showSelectCustom = false
				this.newContract.custom_name = val.custom_name
				this.newContract.custom_id = val.custom_id
			},
            setCustom(id,name){
			    this.I(name)
                this.newContract.custom_name = name
                this.newContract.custom_id = id
            },
			//选择客户子组件点击叉的回调
			hiddenSelectCustom(){
				this.showSelectCustom = false
			},
			//联系人手动输入
			inputCustom(e){
				let value = e.target.value
				for (var i=0;i<this.searchCustomerArr&&this.searchCustomerArr.length;i++) {
					// if(this.searchCustomerArr[i].custom_name.indexOf(value))
					// console.log(this.searchCustomerArr[i].custom_name.indexOf(value))
				}
			},
			//选择合同标签
			selectLabels(){
				this.showSelectLabel = true
			},
			//选择标签子组件点击叉的回调
			hiddenSelectLabel(){
				this.showSelectLabel = false
			},
			//选择标签的渲染
			ChoosedLabels(val){
				this.showSelectLabel = false
				val = JSON.parse(val)
				this.newContract.label_name = []
				this.newContract.label_id = []
				for(let i=0;i<val.label_name.length;i++)
				{
					this.newContract.label_name.push(val.label_name[i])
					this.newContract.label_id.push(val.label_id[i])
				}
				this.newContract.label_id = this.newContract.label_id.join(',')
			},
			//选择联系人
			selectLinkMan(){
				this.showSelectLinkMan = true
			},
			//选择联系人的回调
			hiddenSelectLinkman(){
				this.showSelectLinkMan = false
			},
			//选择跟进人
			selectFollow(){
			
			},
			//选择图片
			upload(e){
				let files = e.target.files
				// let nowFiles = this.newContract.files ? this.newContract.files : []
				
				for(let i=0;i<files.length;i++)
				{
					this.fileMap.push(files[i])
					this.yulanFiles.push(URL.createObjectURL(files[i]))
					this.newContract.files.push(files[i])
				}
			},
			//预览图片
			yulan(key){

			},
			//删除图片
			delImg(key){
				this.fileMap.splice(key, 1)
				this.yulanFiles.splice(key, 1)
			},

			//关闭组件
			closeNewContract(){

				this.$emit('closeNewContract')
			},
			//打开手动添加回馈组件
			openShoudong(){
				this.showAutoMatic =false
				this.showManual = true
			},
			//关闭自动回款组件
			hiddenAutoMatic(){
				this.showAutoMatic = false
				this.$emit('closeNewContract')
			},
			//关闭手动回款组件
			hiddenManual(){
				this.showManual = false
				this.$emit('closeNewContract')
			},
			//打开自动添加回款组件
			openZidong(){
				this.showAutoMatic = true

				this.showManual = false
				
			},
			//关闭自动回款和新建合同组件
			closeAutoMacticAndNewContractComponents(){
				this.showAutoMatic = false

				this.$emit('closeAutoMacticAndNewContractComponents')
			},
			//关闭手动回款计划和新建合同组件
			closeManualAndNewContractComponents(){
				this.showManual = false
				
				this.$emit('closeManualAndNewContractComponents')
			},
			 getNowDate(date){
                let newDate = date ? new Date(date) : new Date()
                let year = newDate.getFullYear()
                let month = newDate.getMonth()+1
                let day = newDate.getDate()
                let m = month < 10 ? '0' + month : month
                let d = day < 10 ? '0' + day : day
                return year + '-' + m + '-' + d
            },
		}

	}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->

<style lang="scss" scoped>
	@import "../../../assets/main";
	.centerModal {
		.modalInner {
			.body{
				.newContract {
					.row {
						.chanpin {
							.none {
								width: 94%;
								height: 50px;
								border: $borderStyle;
								border-radius: 3px;
								position: relative;
								div {
									padding-left: 10px;
									line-height: 24px;
									height: 24px;
								}
								.div1 {
									color: #cfd3d9;
									border-bottom: 1px dashed #bfcbd9;
								}
								.choose {
									position: absolute;
									top: 2px;
									right: 10px;
									font-size: 13px;
									color: $mainColor;
									cursor: pointer;
								}
							}
						}
                        #customParent{
                            position:relative;
                            .customModel{
                                z-index:20;
                                position:absolute;
                                left:15px;
                                top:31px;
                                border-radius:5px;
                                width:calc(94% - 15px);
                                height:150px;
                                border:1px solid #999;
                                background-color:#fff;
                                overflow: auto;
                                p{
                                    height:20px;
                                    padding-left:10px;
                                    
                                }
                            }
                        }
						.col-xs-9{
							position: relative;
							.hkzq {
								width: 94%;
								height: 30px;
								border: $borderStyle;
								border-radius: 3px;
								position: relative;
								background: #ffffff;
								select {
									display: block;
									float: left;
									width: 80px;
									border: 0;
									-webkit-appearance: textfield;

								}
								input {
									width: 89%;
								}
								span {
									line-height: 30px;
									display: block;
									float: left;
								}
							}
							table {
								tr {
									td {
										white-space: nowrap;
										line-height: 24px;
										span {
											display: block;
											float: left;
											margin-right: 3px;
										}
									}
									td:nth-child(1) input {
										width:90px;
									}
									td:nth-child(2) input {
										width: 60px;
									}
									td:nth-child(3) input {
										width: 30px;
									}
									td:nth-child(4) input {
										width: 30px;
									}
								}
								input {
									display: inline-block;
									height: 24px;
									padding: 0 3px;
								}
								i {
									font-size: 12px;
									cursor: pointer;
								}
							}
							.preset {
								position: absolute;
								top: 32px;
								left: 15px;
								width: 91%;
								background: #ffffff;
								z-index: 11;
								
								li {
									padding-left: 15px;
									list-style: none;
									line-height: 28px;
								}
								.active {
									background: #e7eef9;
								}
							}
							.genjinren {
								position: absolute;
								top: 32px;
								left: 16px;
								z-index: 13;
								height: 160px;
								overflow: auto;
								background: $baiColor;
								box-shadow: 0 0px 6px rgba(0,0,0,0.35);
								.level {
									width: 280px;
									height: 160px;
									float: left;
									border-right: 1px solid #d0d3dc;
									ul {
										padding-left: 24px;
										li {
											line-height: 28px;
											i {
												margin: 0 2px;
												cursor: pointer;
											}
											i:first-child{
												font-size: 16px;
												color: #d0d3dc;
											}
											i:nth-child(2) {
												font-size: 14px;
												color: $mainColor;
											}
										}
									}
								}
								.persons {
									float: left;
									width: 150px;
									height: 160px;
									ul {
										padding: 10px 0 20px 30px;
										li {
											line-height: 30px;
											cursor: pointer;
											i {
												color: $mainColor;
											}
										}
									}
								}
							}
						}
					}
					.atte {
						margin-bottom: -4px;
						padding-left: 430px;
						span {
							color: $mainColor;
						}
					}
				}
			}
		}
	}
 
</style>
