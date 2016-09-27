require 'test_helper'

class LayoutsControllerTest < ActionController::TestCase
  test "should get readme" do
    get :readme
    assert_response :success
  end

end
