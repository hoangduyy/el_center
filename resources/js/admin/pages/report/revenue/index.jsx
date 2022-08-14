import React, { useState, useEffect } from "react";
import moment from "moment";
import ColumnChart from "./component/chart/ColumnChart";
import Table from "./component/table/index";
const { Space,Button } = require("antd");
import Calendar from "../../../components/calendar";
import Breadcrumb from "../../../components/breadcrumbs";
import {FileExcelOutlined } from "@ant-design/icons";

const enumerateDaysBetweenDates = function (startDate, endDate) {
    var dates = [];
    var currDate = moment(startDate).startOf("day");
    var lastDate = moment(endDate).startOf("day");
    while (currDate.add(1, "days").diff(lastDate) < 0) {
        dates.push(currDate.clone().toDate());
    }
    return dates;
};

const startOfMonth = moment().clone().startOf("month").format("YYYY-MM-DD");
function ReportRevenue() {
    const [startDate, setStartDate] = useState(startOfMonth);
    const [endDate, setEndDate] = useState(moment().format("YYYY-MM-DD"));
    const [data, setDatta] = useState(null);
    const [listDates, setListDates] = useState([]);

    useEffect(async () => {
        console.log(startDate,'startDate -xxxxxxxxxx');
        const { data } = await axios.get(
            `/api/admin/report/revenue?start_date=${startDate}&end_date=${endDate}`
        );

        setDatta(data.data);
        setListDates(
            enumerateDaysBetweenDates(
                moment(startDate).add(-1, "d"),
                moment(endDate).add(1, "d")
            ).map((item) => moment(item).format("DD/MM/YYYY"))
        );
    }, [startDate, endDate]);

    return (
        <div className="row">
            <Breadcrumb items={["Báo cáo lớp học"]}>
                <Space>
                    <Calendar
                        name="startDate"
                        onChange={(date) =>
                            {
                                setStartDate(
                                    date
                                )
                            }
                      
                        }
                        placeholder="Start date"
                        defaultValue={moment().clone().startOf("month")}
                    />
                    <Calendar
                        name="endDate"
                        onChange={(date) =>
                            setEndDate(
                                date
                                // moment(date, "DD-MM-YYYY").format("YYYY-MM-DD")
                            )
                        }
                        placeholder="End date"
                        defaultValue={moment()}
                    />
                </Space>
                <Button
                    onClick={() => {
                        window.location.href =
                            "/api/admin/report/revenue/export?start_date=" + startDate + "&end_date=" + endDate;
                    }}
                    className="ml-auto"
                    type="primary"
                >
                    <FileExcelOutlined />
                </Button>
            </Breadcrumb>
            <div className="col-12">
                <ColumnChart
                    categories={listDates}
                    series={[
                        {
                            name: "Doanh thu",
                            data: Array.isArray(data)
                                ? data.map((item) => item.totalAmount)
                                : [],
                        },
                    ]}
                />
            </div>
            <div className="col-12 mt-4">
                <Table
                    data={Array.isArray(data) ? data : []}
                    listDates={Array.isArray(listDates) ? listDates : []}
                />
            </div>
        </div>
    );
}

export default ReportRevenue;
