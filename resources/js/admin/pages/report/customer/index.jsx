import React, { useState, useEffect } from "react";
import moment from "moment";
import ColumnChart from "./component/chart/ColumnChart";
import Table from "./component/table/index";
const { Button, Space } = require("antd");
import Calendar from "../../../components/calendar";
import Breadcrumb from "../../../components/breadcrumbs";

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

function ReportCustomer() {
    const [startDate, setStartDate] = useState(startOfMonth);
    const [endDate, setEndDate] = useState(moment().format("YYYY-MM-DD"));
    const [data, setDatta] = useState(null);
    const [listDates, setListDates] = useState([]);

    useEffect(async () => {
        const { data } = await axios.get(
            `/api/admin/report/customer?start_date=${startDate}&end_date=${endDate}`
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
            <Breadcrumb items={["Báo cáo tương tác Học viên"]}>
                <Space>
                    <Calendar
                        name="startDate"
                        onChange={(date) =>
                            setStartDate(
                                moment(date, "DD-MM-YYYY").format("YYYY-MM-DD")
                            )
                        }
                        placeholder="Start date"
                        defaultValue={moment().clone().startOf("month")}
                    />
                    <Calendar
                        name="endDate"
                        onChange={(date) =>
                            setEndDate(
                                moment(date, "DD-MM-YYYY").format("YYYY-MM-DD")
                            )
                        }
                        placeholder="End date"
                        defaultValue={moment()}
                    />
                </Space>
            </Breadcrumb>
            <div className="col-12">
                <ColumnChart
                    categories={listDates}
                    series={[
                        {
                            name: "Học viên",
                            colorByPoint: true,
                            data: [
                                {
                                    name: "Học viên mới",
                                    y: Array.isArray(data) ? 
                                        data.map(item => item.totalNewCustomer).reduce(
                                            (previousValue, currentValue) => previousValue + parseInt(currentValue) ,
                                            0
                                        ) 
                                        : 0,
                                    sliced: true,
                                    selected: true,
                                },
                                {
                                    name: "Học viên cũ",
                                    y: Array.isArray(data) ?    
                                    data.map(item => item.totalOldCustomer).reduce(
                                        (previousValue, currentValue) => previousValue + parseInt(currentValue) ,
                                        0
                                    )  : 0,
                                },
                            ],
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

export default ReportCustomer;
