<tbody>
    <tr>
        <td class="wrapper">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <p><strong>Hi Mary Funeral, you have a new message from <?=$data["name"];?>.</strong></p>
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="">
                            <tbody>
                                <tr>
                                    <td width="50%" align="left"><strong>EMAIL or PHONE</strong></td>
                                    <td align=""><?=$data["email"];?></td>
                                </tr>
                                <tr>
                                    <td align="left"><strong>Purpose</strong></td>
                                    <td align=""><?=$data["topic"];?></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="">
                                        <p><?=json_decode($data["message"]);?></p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</tbody>