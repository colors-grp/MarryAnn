package com.colors.supersaym.controller.communication;

public interface AsyncTaskListener {
	void onStart(Task task);

	void onFinish(Task task);

}
