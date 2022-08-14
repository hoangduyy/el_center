import {Col, Row } from "antd";
import React, { useEffect, useState } from "react";
import {
  DollarCircleOutlined,
  HddFilled,
  UserSwitchOutlined,
  FormOutlined,
} from "@ant-design/icons";
import CardOverview from "./component/CardOverview";
import ColumnChart from "./component/Chart/ColumnChart";

import moment from "moment";

const enumerateDaysBetweenDates = function (startDate, endDate) {
  var dates = [];
  var currDate = moment(startDate).startOf("day");
  var lastDate = moment(endDate).startOf("day");
  while (currDate.add(1, "days").diff(lastDate) < 0) {
    dates.push(currDate.clone().toDate());
  }
  return dates;
};

const startOfMonth = moment()
  .clone()
  .startOf("month")
  .format("YYYY-MM-DD hh:mm");
const listDates = enumerateDaysBetweenDates(
  moment(startOfMonth).add(-1, "d"),
  moment().add(1, "d")
).map((item) => moment(item).format("DD/MM/YYYY"));

function Dashboard() {
  const [data, setDatta] = useState(null);

  useEffect(async () => {

    const  {data}  = await axios.get("/api/admin/report/overview");
    console.log(data,'data');
    setDatta(data.data);

  }, []);

  return (
    <div className="site-card-wrapper">
      {/* {showViews["over-view-general"] ? ( */}
        <>
          <Row gutter={16}>
            <Col span={6}>
              <CardOverview
                title={"Doanh thu"}
                icon={
                  <DollarCircleOutlined
                    style={{ fontSize: 30, color: "#16a085" }}
                  />
                }
                total={ (data?.totalDiscount ? data.totalDiscount.toLocaleString() : 0) + " đ"}
              />
            </Col>
            <Col span={6}>
              <CardOverview
                title={"Lớp"}
                icon={<HddFilled style={{ fontSize: 30, color: "#2980b9" }} />}
                total={data?.countProduct}
              />
            </Col>
            <Col span={6}>
              <CardOverview
                title={"Đơn đăng ký"}
                icon={
                  <FormOutlined  style={{ fontSize: 30, color: "#2980b9" }} />
                }
                total={data?.countNewOrder}
              />
            </Col>
            <Col span={6}>
              <CardOverview
                title={"Học viên"}
                icon={
                  <UserSwitchOutlined
                    style={{ fontSize: 30, color: "#27ae60" }}
                  />
                }
                total={data?.countNewCustomer}
              />
            </Col>
          </Row>
          <div className="row mt-5">
            <div className="col-6">
              <ColumnChart
                categories={listDates}
                series={[
                  {
                    name: "Doanh thu",
                    data: data?.totalAmount ? data.totalAmount.map(item => item.total ) : [],
                  }
                ]}
              />
            </div>
          </div>
        </>
      {/* )} */}
    </div>
  );
}

export default Dashboard;
