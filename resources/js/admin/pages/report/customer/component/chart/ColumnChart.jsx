import React, { Component } from "react";
import HighchartsReact from "highcharts-react-official";
import Highcharts from "highcharts";
import moment from "moment";
import { Card } from "antd";

const currentDate = moment().format("HH:mm ngà\\y DD t\\háng MM nă\\m YYYY");
const defaultOptions = {
  chart: {
    plotBackgroundColor: null,
    plotBorderWidth: null,
    plotShadow: false,
    type: "pie",
  },
  title: {
    text: "Biểu đồ tổng quan tương tác học viên trong tháng",
  },
  subtitle: {
    text: "Số liệu tính đến " + currentDate,
  },
  tooltip: {
    pointFormat: "{series.name}: <b>{point.percentage:.1f}%</b>",
  },
  accessibility: {
    point: {
      valueSuffix: "%",
    },
  },
  plotOptions: {
    pie: {
      allowPointSelect: true,
      cursor: "pointer",
      dataLabels: {
        enabled: true,
        format: "<b>{point.name}</b>: {point.percentage:.1f} %",
      },
    },
  },
  series: [],
};

export default class ColumnChart extends Component {
  constructor(props) {
    super(props);
    this.state = {
      categories: [],
      series: [],
    };
  }

  render() {
    let { series, categories } = this.props;
    series = series ?? [];
    const options = { ...defaultOptions };
    const chartConfig = {
      ...options,
      series: [...series],
    };

    return (
      <Card>
        <HighchartsReact highcharts={Highcharts} options={chartConfig} />
      </Card>
    );
  }
}
