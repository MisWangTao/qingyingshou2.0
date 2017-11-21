import Vue from 'vue'
import Router from 'vue-router'

//首页
import Home from '@/page/home/home'
// 客户列表
import Customer from '@/page/customer/customer'
// 客户详情
import Kehuxinxi from '@/page/customer/kehuxiangqing/kehuxinxi'
// 编辑客户
import EditCustom from '@/page/customer/kehuxiangqing/editCustomer/editCustom'
// 新建客户
import NewCustom from '@/page/newCustom/newCustom'
// 新建合同
import NewContract from '@/page/newContract/newContract'

// 合同标签
import ContractLabel from '@/page/newContract/contractLabel/contractLabel'
// 合同标签
import EditContractLabel from '@/page/contract/editContract/contractLabel/contractLabel'
// 编辑合同
import EditContract from '@/page/contract/editContract/editContract'
//合同列表
import ContractList from '@/page/contract/contractList'
//合同信息
import ContractInfo from '@/page/contract/contractInfo/contractInfo'
//合同详情
import ContractDetail from '@/page/contract/contractInfo/contractDetail/contractDetail'
//添加合同款
import AddPayment from '@/page/contract/contractInfo/addPayment/addPayment'
// 自动生成回款计划
import PaymentPlan from '@/page/newContract/paymentPlan/paymentPlan'
// 手动添加回款计划
import AddhuikuanPlan from '@/page/newContract/addhuikuanPlan/addhuikuanPlan'
// 新建回款
import NewReceivable from '@/page/newReceivable/newReceivable'
// 核销
import WriteOff from '@/page/newReceivable/writeOff/writeOff'
// 回款管理
import PaymentManage from '@/page/home/paymentManage/paymentManage'
// 回款详情
import PaymentDetail from '@/page/home/paymentManage/paymentDetail/paymentDetail'
// 退款详情
import RefundDetails from '@/page/home/paymentManage/refundDetails/refundDetails'
// 消息提醒
import Remind from '@/page/home/remind/remind'
// 认领回款信息
import ClaimPayment from '@/page/home/remind/claimPayment/claimPayment'
// 核销确定
import Hexiao from '@/page/home/remind/claimPayment/hexiao/hexiao'
// 待处理预计回款
import EstimatedReturn from '@/page/home/remind/estimatedReturn/estimatedReturn'
// 确认回款
import Confirm from '@/page/home/remind/estimatedReturn/confirm/confirm'
// 预计回款
import ExpectReturn from '@/page/expectReturn/expectReturn'

// 修改回款计划
import Editplan from '@/page/contract/contractInfo/editplan/editplan'
//------------------------------------------------------------
//组件
// 回款计划
import HuikuanPlan from '@/components/huikuanplan/huikuanPlan'
// 选择客户
import SelectIndustry from '@/page/newCustom/selectIndustry/selectIndustry'
// 选择联系人
import SelectLinkman from '@/components/selectLinkman/selectLinkman'
// 部门列表
import DepartList from '@/components/selectLinkman/departList'
// 选择合同
import OptionContract from '@/components/optionContract/optionContract'
// 选择客户
import SelectCustomer from '@/components/selectCustomer/selectCustomer'


Vue.use(Router)

export default new Router({
    mode: 'history',
    scrollBehavior: () => ({y: 0}),
    routes: [
        {
            path: '/',
            component: Home
        }, {
            path: '/home',
            component: Home
        }, {
            path: '/customer',
            component: Customer
        }, {
            path: '/kehuxinxi/:customid',
            component: Kehuxinxi
        }, {
            path: '/editCustom',
            component: EditCustom
        }, {
            path: '/newCustom',
            component: NewCustom
        }, {
            path: '/newContract',
            component: NewContract
        }, {
            path: '/selectCustomer',
            component: SelectCustomer
        }, {
            path: '/contractLabel',
            component: ContractLabel
        },{
            path: '/editContractLabel',
            component: EditContractLabel
        }, {
            path: '/editContract/:id',
            component: EditContract
        }, {
            path: '/contractList',
            component: ContractList
        }, {
            path: '/contractInfo/:id',
            component: ContractInfo
        }, {
            path: '/contractDetail/:id',
            component: ContractDetail
        }, {
            path: '/paymentPlan/:id',
            component: PaymentPlan
        }, {
            path: '/addhuikuanPlan/:id',
            component: AddhuikuanPlan
        }, {
            path: '/huikuanPlan/:id',
            component: HuikuanPlan
        }, {
            path: '/editplan/:id',
            component: Editplan
        }, {
            path: '/newReceivable',
            component: NewReceivable
        }, {
            path: '/writeOff',
            component: WriteOff
        }, {
            path: '/paymentManage',
            component: PaymentManage
        }, {
            path: '/paymentDetail/:id',
            component: PaymentDetail
        }, {
            path: '/addPayment/:id',
            component: AddPayment
        }, {
            path: '/refundDetails/:id',
            component: RefundDetails
        }, {
            path: '/remind',
            component: Remind
        }, {
            path: '/claimPayment/:id',
            component: ClaimPayment
        }, {
            path: '/hexiao/:id',
            component: Hexiao
        }, {
            path: '/estimatedReturn/:id',
            component: EstimatedReturn
        }, {
            path: '/confirm/:id',
            component: Confirm
        },{
            path: '/expectReturn',
            component: ExpectReturn
        }, {
            path: '/optionContract/:id',
            component: OptionContract
        }, {
            path: '/selectIndustry',
            component: SelectIndustry
        },{
            path: '/selectLinkman',
            component: SelectLinkman
        },{
            path: '/departList/:id',
            component: DepartList
        }, {
            path: '*',
            redirect: '/home'
        },
    ],
})
