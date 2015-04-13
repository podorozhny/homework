$(document).ready(function () {
    Chart.defaults.global.multiTooltipTemplate = '<%if (datasetLabel){%><%=datasetLabel%>: <%}%><%= value %>';
    
    var clientsCountCtx = $('#canvas-clients-count').get(0).getContext('2d'),
        clientsInflowCtx = $('#canvas-clients-inflow').get(0).getContext('2d'),
        usersCtx = $('#canvas-users').get(0).getContext('2d'),
        transactionsCtx = $('#canvas-transactions').get(0).getContext('2d'),
        goodsWeightCtx = $('#canvas-goods-weight').get(0).getContext('2d'),
        goodsSpaceCtx = $('#canvas-goods-space').get(0).getContext('2d');
    
    window.clientsCountLine = new Chart(clientsCountCtx).Line(chartsData.clientsCount);
    window.clientsInflowBar = new Chart(clientsInflowCtx).Bar(chartsData.clientsInflow);
    window.usersLine = new Chart(usersCtx).Line(chartsData.users);
    window.transactionsBar = new Chart(transactionsCtx).Bar(chartsData.transactions);
    window.goodsWeightPie = new Chart(goodsWeightCtx).Pie(chartsData.goodsWeight);
    window.goodsSpaceDoughnut = new Chart(goodsSpaceCtx).Doughnut(chartsData.goodsSpace);
});