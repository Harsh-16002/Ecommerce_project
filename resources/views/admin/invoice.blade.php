<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background: #f4f4f4;
        }

        .invoice-box {
            max-width: 800px;
            margin: 20px auto;
            padding: 30px;
            border: 1px solid #eee;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
            position: relative;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
            position: relative;
        }

        .invoice-box table tr.top table td.title .by-harsh {
            position: absolute;
            bottom: 0;
            right: 0;
            font-size: 14px;
            color: #555;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="5">
                    <table>
                        <tr>
                            <td class="title">
                                <h2>BUY_IT</h2>
                                <span class="by-harsh">by Harsh</span>
                            </td>
                            <td>
                                <?php
                                    $createdDate = date('F d, Y'); // Today's date
                                    $dueDate = date('F d, Y', strtotime($createdDate. ' + 10 days')); // Due date 10 days from today
                                ?>
                                Invoice #: 123<br>
                                Created: <?php echo $createdDate; ?><br>
                                Due: <?php echo $dueDate; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="5">
                    <table>
                        <tr>
                            <td>
                                BUT-IT, Inc.<br>
                                Green valley Bhilai<br>
                                Junwani Bhilai, 490020
                            </td>
                            <td>
                                {{$data->name}}<br>
                                {{$data->User->email}}<br>
                                {{$data->phone}}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="heading">
                <td>
                    Product Category
                </td>
                <td>
                    Product Item
                </td>
                <td>
                    Item
                </td>
                <td>
                    Price
                </td>
                <td>
                    Total
                </td>
            </tr>
            
            <tr class="item last">
                <td>
                    {{$data->product->category}}
                </td>
                <td>
                    {{$data->product->title}}
                </td>
                <td>
                    {{$data->product->price}}
                </td>
                <td>
                    {{$data->product->price}}
                </td>
            </tr>
            
            <tr class="total">
                <td colspan="4"></td>
                <td>
                   Total: {{$data->product->price}}
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
