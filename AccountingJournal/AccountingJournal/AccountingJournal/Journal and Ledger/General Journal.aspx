<%@ Page Title="" Language="C#" MasterPageFile="~/GeneralSite.Master" AutoEventWireup="true" CodeBehind="General Journal.aspx.cs" Inherits="AccountingJournal.Journal_and_Ledger.General_Journal" %>

<%@ Register Assembly="AjaxControlToolkit" Namespace="AjaxControlToolkit" TagPrefix="cc1" %>
<asp:Content ID="Content1" ContentPlaceHolderID="head" runat="server">
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder1" runat="server">
    <div class="container">
        <div class="panel panel-primary form-group">
            <div class="panel-heading text-center">
                General Journal
            </div>
            <div class="panel-body">
                <div id="filter" runat="server">
                    <form runat="server">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label for="startDate">Start Date: </label>
                                    <div class="input-group">
                                        <input type='text' class="datepicker form-control" placeholder="Start Date" name='startDate'/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <label for="endDate">End Date: </label>
                                    <div class="input-group">
                                        <input type='text' class="datepicker form-control" placeholder="End Date" name='endDate'/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style='height: 15px;'></div>
                        </div>
                    </form>
                </div>
                <table class="table borderless" id="Jourtab">
                    <thead>
                        <tr style="font-weight: bolder; border-bottom: solid; border-color: black; background-color: white">
                            <td class="text-center">Date</td>
                            <td>Account Titles and Explanation</td>
                            <td class="text-right">Ref.</td>
                            <td class="text-center">Debit</td>
                            <td class="text-center">Credit</td>
                            <td class="text-center">Posted Date</td>
                        </tr>
                    </thead>
                    <asp:Label ID="IndJour" runat="server"></asp:Label>
                </table>
            </div>
        </div>
    </div>
</asp:Content>
