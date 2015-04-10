<%@ Page Title="" Language="C#" MasterPageFile="~/GeneralSite.Master" AutoEventWireup="true" CodeBehind="journalentry.aspx.cs" Inherits="AccountingJournal.journalentry" %>

<asp:Content ID="Header1" ContentPlaceHolderID="head" runat="server">
    <script type="text/javascript">
        var dr_ct = 2;
        var cr_ct = 2;
        var last_dr_id = "debit_1";
        var last_cr_id = "credit_1";
    </script>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>
        function DebBrowser0() {
            document.getElementById('<%= DebFileUpload0.ClientID %>').click();
        }

        function CreBrowser0() {
            document.getElementById('<%= CreFileUpload0.ClientID %>').click();
        }

    </script>

</asp:Content>
<asp:Content ID="Content1" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">
    <div>
        <div>
            <div style="text-align: center; background-color: darkblue; color: white; height: 30px; font-size: large; vertical-align: central; font-weight: bold">
                General Journal
            </div>
            <div id="my_table_body">
                <table>
                    <thead>
                        <tr>
                            <th class="t_date">Date</th>
                            <th class="t_acct_title">Account Title and Explanation</th>
                            <th class="t_src">Src</th>
                            <th class="t_ref">Ref</th>
                            <th class="t_debit">Debit</th>
                            <th class="t_credit">Credit</th>
                            <th class="t_action">Action</th>
                        </tr>
                    </thead>
                    <tbody id="debits">
                        <tr id="debit_0" runat="server">
                            <td class="t_date">
                                <asp:TextBox ID="date" runat="server" placeholder="Date" Width="100px" CssClass="t_box"></asp:TextBox>
                            </td>
                            <td class="t_acct_title">
                                <div class="form-group">
                                    <div class='input-group input-ammend debit_acct_name'>
                                        <asp:DropDownList ID="accDebt_title0" runat="server" DataSourceID="TransactionDB" DataTextField="Name" CssClass="Dr_box" DataValueField="Name" AppendDataBoundItems="True">
                                            <asp:ListItem>--Select--</asp:ListItem>
                                        </asp:DropDownList>
                                        <asp:SqlDataSource ID="TransactionDB" runat="server" ConnectionString="<%$ ConnectionStrings:TransactionDBConnectionString %>" SelectCommand="SELECT [Name], [AccountID] FROM [Account] WHERE ([IsActive] = @IsActive)">
                                            <SelectParameters>
                                                <asp:Parameter DefaultValue="true" Name="IsActive" Type="Boolean" />
                                            </SelectParameters>
                                        </asp:SqlDataSource>
                                    </div>
                                </div>
                            </td>
                            <td class="t_src">
                                <asp:ImageButton ID="DebImageButt0" runat="server" ImageUrl="~/Images/document_icon.png" OnClientClick="DebBrowser0()" /><asp:FileUpload ID="DebFileUpload0" runat="server" Style="visibility: hidden; width: 30px;" />
                            </td>
                            <td class="t_ref">
                                <asp:TextBox CssClass="t_box" ID="Debref0" placeholder="Ref" runat="server" Width="30"></asp:TextBox>
                            </td>
                            <td class="t_debit">
                                <asp:TextBox CssClass="t_box" ID="debit0" placeholder="Amt" name="debit" runat="server"></asp:TextBox>
                            </td>
                            <td class="t_credit"></td>
                            <td class="t_action">
                                <asp:Button ID="AddDebBut0" runat="server" Text="Add" CssClass="butt" Width="50px" OnClick="AddDebBut0_Click" BackColor="DarkBlue" />
                            </td>
                        </tr>
                        <tr id="debDis">
                            <td></td>
                            <td colspan="5">
                                <asp:GridView ID="DebGrid" runat="server" AutoGenerateColumns="False" CellPadding="4" ForeColor="#333333" GridLines="None">
                                    <AlternatingRowStyle BackColor="White" />
                                    <Columns>
                                        <asp:BoundField DataField="AccountTitle" HeaderText="Account Title" />
                                        <asp:BoundField DataField="Source" HeaderText="Source" />
                                        <asp:BoundField DataField="Ref" HeaderText="References" />
                                        <asp:BoundField DataField="Debit" HeaderText="Debit" />
                                        <asp:BoundField DataField="Credit" HeaderText="Credit" />
                                    </Columns>
                                    <EditRowStyle BackColor="#2461BF" />
                                    <FooterStyle BackColor="#507CD1" Font-Bold="True" ForeColor="White" />
                                    <HeaderStyle BackColor="#507CD1" Font-Bold="True" ForeColor="White" />
                                    <PagerStyle BackColor="#2461BF" ForeColor="White" HorizontalAlign="Center" />
                                    <RowStyle BackColor="#EFF3FB" />
                                    <SelectedRowStyle BackColor="#D1DDF1" Font-Bold="True" ForeColor="#333333" />
                                    <SortedAscendingCellStyle BackColor="#F5F7FB" />
                                    <SortedAscendingHeaderStyle BackColor="#6D95E1" />
                                    <SortedDescendingCellStyle BackColor="#E9EBEF" />
                                    <SortedDescendingHeaderStyle BackColor="#4870BE" />
                                </asp:GridView>
                            </td>
                        </tr>
                        <tr id="credit_0" runat="server">
                            <td></td>
                            <td>
                                <div>
                                    <div>
                                        <asp:DropDownList ID="accCredit_title0" runat="server" DataSourceID="TransactionDB" DataTextField="Name" CssClass="Dr_box" DataValueField="AccountID" AppendDataBoundItems="True">
                                            <asp:ListItem>--Select--</asp:ListItem>
                                        </asp:DropDownList>
                                        <asp:SqlDataSource ID="SqlDataSource1" runat="server" ConnectionString="<%$ ConnectionStrings:TransactionDBConnectionString %>" SelectCommand="SELECT [Name], [AccountID] FROM [Account] WHERE ([IsActive] = @IsActive)">
                                            <SelectParameters>
                                                <asp:Parameter DefaultValue="true" Name="IsActive" Type="Boolean" />
                                            </SelectParameters>
                                        </asp:SqlDataSource>
                                    </div>
                                </div>
                            </td>
                            <td class="t_src">
                                <asp:ImageButton ID="CreImageButt0" runat="server" ImageUrl="~/Images/document_icon.png" OnClientClick="CreBrowser0()" /><asp:FileUpload ID="CreFileUpload0" runat="server" Style="visibility: hidden; width: 30px;" />
                            </td>
                            <td class="t_ref">
                                <asp:TextBox CssClass="t_box" ID="Creref0" placeholder="Ref" name="reference" runat="server" Width="30px"></asp:TextBox>
                            </td>
                            <td class="t_debit"></td>
                            <td class="t_credit">
                                <asp:TextBox CssClass="t_box" ID="credit0" placeholder="Amt" name="credit" runat="server"></asp:TextBox>
                            </td>
                            <td class="t_action">
                                <asp:Button ID="AddCreBut0" runat="server" Text="Add" CssClass="butt" OnClick="AddCreBut0_Click" Width="50px" BackColor="DarkBlue" />
                            </td>
                        </tr>
                        <tr id="creDis">
                            <td></td>
                            <td colspan="5">
                                <asp:GridView ID="CreGrid" runat="server"></asp:GridView>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div style="text-align: center">
                    <asp:TextBox CssClass="t_box" ID="trans_desc" placeholder="Description" name="trans_desc" runat="server" TextMode="MultiLine" Width="800px" Height="100px"></asp:TextBox>
                </div>
                <div style="text-align: right">
                    <asp:Button ID="attempt_post" runat="server" Text="Submit" CssClass="butt" OnClick="attempt_post_Click" BackColor="#0a88f3" Width="80px" />
                    <asp:Button ID="clear_entry" runat="server" Text="Clear" CssClass="butt" OnClick="clear_entry_Click" BackColor="red" Width="80px" />
                </div>
            </div>
        </div>
    </div>
</asp:Content>
