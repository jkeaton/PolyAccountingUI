<%@ Page Title="" Language="C#" MasterPageFile="~/Account/Empty.Master" AutoEventWireup="true" CodeBehind="SignIn.aspx.cs" Inherits="AccountingJournal.Account.WebForm1" %>

<asp:Content ID="Content1" ContentPlaceHolderID="head" runat="server">
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">
    <div class="container">
        <div class="panel panel-primary col-centered form-group">
            <div class="panel-heading text-center" style="font-size: x-large">
                Sign In
            </div>
            <div id="SignContent">
                <table>
                    <tr>
                        <td style="width: 300px"></td>
                        <td style="width: 450px;">
                            <table>
                                <tr>
                                    <td style="text-align: right; font-size: large;">Username:</td>
                                    <td>
                                        <div style="text-align: center">
                                            <asp:TextBox ID="SigUname" runat="server" placeholder="Username" CssClass="SignBox" ValidationGroup="SignIn"></asp:TextBox>
                                            <asp:RequiredFieldValidator ID="SigUnameValidator" runat="server" ErrorMessage="*" ControlToValidate="SigUname" ForeColor="Red" ValidationGroup="SignIn"></asp:RequiredFieldValidator>
                                        </div>
                                    </td>

                                </tr>
                                <tr>
                                    <td style="text-align: right; font-size: large;">Password:</td>
                                    <td>
                                        <div style="text-align: center ; margin-bottom:1px;">
                                            <asp:TextBox ID="SigPass" runat="server" placeholder="Password" CssClass="SignBox" TextMode="Password" ValidationGroup="SignIn"></asp:TextBox>
                                            <asp:RequiredFieldValidator ID="SigPassValidator" runat="server" ErrorMessage="*" ControlToValidate="SigPass" ForeColor="Red" ValidationGroup="SignIn"></asp:RequiredFieldValidator>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <table style="width:300px">
                                            <tr>
                                                <td><div style="margin-left:25px; margin-bottom:1px">
                                                    <asp:LinkButton ID="Regis" runat="server" OnClick="Regis_Click">Creare a new account</asp:LinkButton>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>

                                                <td><div style="margin-left:25px">
                                                    <asp:LinkButton ID="FgPass" runat="server" OnClick="FgPass_Click">I forgot my password</asp:LinkButton>
                                                </div>
                                                    </td>
                                            </tr>

                                        </table>
                                    </td>

                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <div style="text-align: center">
                                            <asp:Button ID="SigButt" runat="server" Text="SignIn" class="btn btn-primary" OnClick="SigButt_Click" ValidationGroup="SignIn" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <asp:Label ID="SigMess" runat="server" ForeColor="Red"></asp:Label></td>
                                </tr>
                            </table>
                        </td>
                        <td style="width: 300px;"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</asp:Content>
