Необходимо реализовать приложение, отвечающее следующим требованиям:
	1) Должны быть реализованы возможности авторизации и регистрации. Неавторизованному пользователю показывается только форма авторизации с возможностью перейти на форму регистрации;
	2) Минимальный набор полей для регистрации: имя, логин, email, пароль, телефон;
	3) Авторизация должна быть реализована посредством ajax запроса. В случае невалидных данных необходимо уведомить об этом пользователя (подсветка полей или alert окно);
	4) После успешной авторизации пользователь должен переходить на форму редактирования профиля, где он может изменить и сохранить свои данные (телефон, имя, email);
	5) Данные пользователей должны храниться в СУБД Mysql;
	6) Архитектура приложения должна отвечать концепции MVC и иметь единую точку входа. При этом запрещается использование каких-либо PHP фреймворков.

В качестве загрузчика классов можно использовать autoloader Composer`а.
Для реализации js кода можно использовать библиотеку jQuery.